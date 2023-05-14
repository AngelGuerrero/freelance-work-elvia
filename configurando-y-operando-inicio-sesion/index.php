<?php
$errorMessage = '';
$showAlert = false;

$credentials = [
  'email' => 'email@test.com',
  'password' => '123456'
];

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if (isset($_POST['submit'])) {
  $showAlert = true;

  if ($email !== $credentials['email'] || $password !== $credentials['password']) {
    $errorMessage = 'El email o la contraseña son incorrectos';
  } else {
    $errorMessage = 'Inicio de sesión exitoso';
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Configurando y operando inicio de sesión</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <nav class="nav">
      <h3 class="nav__title">Inicio de sesión</h3>
    </nav>

    <section class="side-left"></section>

    <main class="main">
      <?php if ($showAlert): ?>
        <div class="
          <?php if ($errorMessage === 'Inicio de sesión exitoso'): ?>
            container__success
          <?php else: ?>
            container__error
          <?php endif; ?>
        ">
          <p>
            <?php echo $errorMessage; ?>
          </p>
        </div>
      <?php endif; ?>

      <!-- Imprime el formulario de login -->
      <?php echo file_get_contents('./form.html'); ?>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>
</body>

</html>