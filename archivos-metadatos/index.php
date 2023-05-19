<?php
session_start();

$COOKIE_TIME = time() + 3600;
$message_error = '';

/**
 * Obtiene los datos enviados por el usuario
 */
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$usersCookie = isset($_COOKIE['users']) ? $_COOKIE['users'] : '';

/**
 * Inicia la sesión del usuario y guarda sus datos
 */
if (file_exists('users.json') && isset($_POST['login'])) {
  $users = file_get_contents('users.json');
  $users_array = json_decode($users, true);

  $find_user = false;
  foreach ($users_array as $key => $value) {
    if ($value['email'] === $email && $value['password'] === $password) {
      $find_user = true;
      break;
    }
  }

  // Guarda los datos del usuario en un archivo JSON
  if ($find_user) {
    $session_user_data = [
      'email' => $email,
      'password' => $password,
    ];

    if (file_exists('session_user_data.json')) {
      $session_user_data_json = file_get_contents('session_user_data.json');
      $session_user_data_array = json_decode($session_user_data_json, true);
      array_push($session_user_data_array, $session_user_data);
      file_put_contents('session_user_data.json', json_encode($session_user_data_array));
    } else {
      $session_user_data_array = array();
      array_push($session_user_data_array, $session_user_data);
      file_put_contents('session_user_data.json', json_encode($session_user_data_array));
    }

    // Obtiene la fecha y hora actual
    $date_time_start = date('Y-m-d H:i:s');

    // Crea la cookie con la fecha y hora de inicio de sesión 
    // en base al nombre del correo electrónico
    $cookie_email_name = explode('@', $email)[0];
    setcookie($cookie_email_name, $date_time_start, $COOKIE_TIME);
    $message_error = '';
  } else {
    $message_error = 'El email o la contraseña son incorrectos';
  }
} else if (isset($_POST['login']) && empty($usersCookie)) {
  $message_error = 'No hay usuarios registrados';
}

/**
 * Valida si hay una sesión iniciada
 */
// $session_user_data = isset($_SESSION['session_user_data']) ? $_SESSION['session_user_data'] : '';
if (file_exists('session_user_data.json')) {
  header('Location: panel.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Archivos de metadatos</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <nav class="nav">
      <h3 class="nav__title">Inicio de sesión</h3>
    </nav>

    <section class="side-left"></section>

    <main class="main">
      <?php if ($message_error): ?>
        <div class="container__error">
          <p>
            <?php echo $message_error; ?>
          </p>
        </div>
      <?php endif; ?>

      <form action="index.php" class="form" method="post">
        <h2 class="container__title">Iniciar sesión</h2>

        <!-- Email -->
        <div class="form__control">
          <label for="email" class="form__label">Email:</label>
          <input type="email" class="form__input" name="email" required />
        </div>

        <!-- Password -->
        <div class="form__control">
          <label for="password" class="form__label">Contraseña:</label>
          <input type="password" class="form__input" name="password" required />
        </div>

        <!-- Submit -->
        <div class="form__control--submit">
          <input type="submit" name="login" class="form__submit" value="Iniciar sesión" />
          <input type="button" name="create_user" class="btn__create_user" value="Crear cuenta" />
        </div>
      </form>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>

  <script>
    const createUserButton = document.querySelector('.btn__create_user');
    createUserButton.addEventListener('click', () => {
      window.location.href = 'create_user.php';
    });
  </script>
</body>

</html>