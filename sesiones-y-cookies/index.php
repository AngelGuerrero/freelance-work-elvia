<?php
session_start();

$COOKIE_TIME = time() + 3600;

$message_error = '';

$credentials = [
  'email' => 'email@test.com',
  'password' => '123456'
];

/**
 * Obtiene los datos enviados por el usuario
 */
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';

/**
 * Inicia la sesión del usuario y guarda sus datos
 */
if (isset($_POST['login'])) {
  if ($email !== $credentials['email'] || $password !== $credentials['password']) {
    $message_error = 'El email o la contraseña son incorrectos';
  } else {
    // Guarda los datos del usuario en la sesión
    $session_user_data = [
      'email' => $email,
      'password' => $password,
      'birthday' => $birthday
    ];
    $_SESSION['session_user_data'] = $session_user_data;

    // Obtiene la fecha y hora actual
    $date_time_start = date('Y-m-d H:i:s');

    // Crea la cookie con la fecha y hora de inicio de sesión
    setcookie('start_date', $date_time_start, $COOKIE_TIME);
  }
}

/**
 * Valida si hay una sesión iniciada
 */
$session_user_data = isset($_SESSION['session_user_data']) ? $_SESSION['session_user_data'] : '';
if (!empty($session_user_data)) {
  header('Location: result.php');
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
      <?php if ($message_error): ?>
        <div class="container__error">
          <p>
            <?php echo $message_error; ?>
          </p>
        </div>
      <?php endif; ?>

      <form action="index.php" class="form" method="post">
        <h2 class="container__title">Iniciar sesión</h2>

        <!-- name -->
        <div class="form__control">
          <label for="name" class="form__label">Nombre:</label>
          <input placeholder="Nombre" type="name" class="form__input" name="name" required />
        </div>

        <!-- Email -->
        <div class="form__control">
          <label for="email" class="form__label">Email:</label>
          <input placeholder="Email" type="email" class="form__input" name="email" required />
        </div>

        <!-- Password -->
        <div class="form__control">
          <label for="password" class="form__label">Contraseña:</label>
          <input placeholder="Email" type="password" class="form__input" name="password" required />
        </div>

        <!-- Birthday -->
        <div class="form__control">
          <label for="birthday" class="form__label">Fecha de nacimiento:</label>
          <input type="date" class="form__input" name="birthday" title="Fecha de nacimiento" required
              value="2023-05-16 07:43:51" />
        </div>

        <!-- Submit -->
        <div class="form__control--submit">
          <input type="submit" name="login" class="form__submit" value="Enviar" />
        </div>
      </form>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>
</body>

</html>