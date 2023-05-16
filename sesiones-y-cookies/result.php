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
  <title>Sesiones y cookies</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <nav class="nav">
      <h3 class="nav__title">Inicio de sesión</h3>
    </nav>

    <section class="side-left"></section>

    <main class="main">
      <?php if ($message_time_passed): ?>
        <div class="container__message">
          <p>
            <?php echo $message_time_passed; ?>
          </p>

          <form action="result.php" method="post">
            <div class="form__control--submit">
              <input type="submit" name="logout" class="btn btn--logout" value="Cerrar sesión" />
            </div>
          </form>
        </div>
      <?php endif; ?>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>
</body>

</html>