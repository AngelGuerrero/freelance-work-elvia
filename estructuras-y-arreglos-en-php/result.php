<?php
session_start();

$message_time_passed = '';

/**
 * Cierra la sesión del usuario
 */
if (isset($_POST['logout'])) {
  // Elimina los datos del usuario de la sesión
  unset($_SESSION['session_user_data']);

  // Elimina la cookie con la fecha y hora de inicio de sesión
  setcookie('start_date', '', time() - 3600);

  header('Location: index.php');
  exit;
}

/**
 * Valida si el usuario ha iniciado sesión y muestra sus datos
 */
$session_user_data = isset($_SESSION['session_user_data']) ? $_SESSION['session_user_data'] : '';
if (!empty($session_user_data)) {
  $date_time_start = $_COOKIE['start_date'];

  $time_passed = strtotime(date('Y-m-d H:i:s')) - strtotime($date_time_start);

  $message_time_passed = "Pasaron $time_passed segundos desde tu último inicio de sesión";
} else {
  header('Location: index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Estructuras y arreglos en PHP</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper--login">
    <nav class="nav--login">
      <h3 class="nav__title">Sesión iniciada</h3>

      <div class="container__form--logout">
        <p>
          <?php echo $message_time_passed; ?>
        </p>
        <form action="result.php" method="post">
          <div class="form__control--submit">
            <input type="submit" name="logout" class="btn btn--logout" value="Cerrar sesión" />
          </div>
        </form>
      </div>
    </nav>

    <main class="main">
      <div class="table">
        <div class="table__header">
          <h3 class="table__title">Datos del usuario</h3>
        </div>

        <div class="table__columns table__titles">
          <div class="table__column">
            <p class="table__column--title">Email</p>
          </div>
          <div class="table__column">
            <p class="table__column--title">Contraseña</p>
          </div>
          <div class="table__column">
            <p class="table__column--title">Fecha de nacimiento</p>
          </div>
          <div class="table__column">
            <p class="table__column--title">Colores favoritos</p>
          </div>
        </div>

        <!-- Mostrar los usuarios guardados en la sesión -->
        <?php if (is_array($session_user_data)): ?>
          <?php foreach ($session_user_data[0] as $user_data): ?>
            <div class="table__columns">
              <div class="table__column">
                <p class="table__column--text">
                  <?php echo $user_data['email']; ?>
                </p>
              </div>
              <div class="table__column">
                <p class="table__column--text">
                  <?php echo $user_data['password']; ?>
                </p>
              </div>
              <div class="table__column">
                <p class="table__column--text">
                  <?php echo $user_data['birthday']; ?>
                </p>
              </div>
              <div class="table__column">
                <p class="table__column--text">
                  <?php if (is_array($user_data['colors'])): ?>
                    <?php foreach ($user_data['colors'] as $color): ?>
                      <span>
                        <?php echo $color; ?>
                      </span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span>
                      <?php echo $user_data['colors']; ?>
                    </span>
                  <?php endif; ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="table__columns">
            <div class="table__column">
              <p class="table__column--text">
                <?php echo $session_user_data['email']; ?>
              </p>
            </div>
            <div class="table__column">
              <p class="table__column--text">
                <?php echo $session_user_data['password']; ?>
              </p>
            </div>
            <div class="table__column">
              <p class="table__column--text">
                <?php echo $session_user_data['birthday']; ?>
              </p>
            </div>
            <div class="table__column">
              <p class="table__column--text">
                <?php if (is_array($session_user_data['colors'])): ?>
                  <span>
                    <?php echo implode(', ', $session_user_data['colors']); ?>
                  </span>
                <?php else: ?>
                  <span>
                    <?php echo $session_user_data['colors']; ?>
                  </span>
                <?php endif; ?>
              </p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>
</body>

</html>