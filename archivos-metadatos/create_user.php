<?php
/**
 * Obtiene los datos enviados por el usuario
 */
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

/**
 * Inicia la sesión del usuario y guarda sus datos
 */
if (isset($_POST['create_user_form'])) {
  $newUser = [
    'name' => $name,
    'email' => $email,
    'password' => $password,
  ];

  if (file_exists('users.json')) {
    $users = file_get_contents('users.json');
    $users_array = json_decode($users, true);
    array_push($users_array, $newUser);
    file_put_contents('users.json', json_encode($users_array));
  } else {
    $users_array = array();
    array_push($users_array, $newUser);
    file_put_contents('users.json', json_encode($users_array));
  }

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
  <title>Actividad integradora. Generación y manejo de estructuras de datos</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <nav class="nav">
      <h3 class="nav__title">Archivos de metadatos</h3>
    </nav>

    <section class="side-left"></section>

    <main class="main">
      <form action="create_user.php" class="form" method="post">
        <h2 class="container__title">Crear cuenta</h2>

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

        <!-- Submit -->
        <div class="form__control--submit">
          <input type="submit" name="create_user_form" class="form__submit" value="Crear cuenta" />
          <input id="btn_redirect_to_home" type="button" name="create_user" class="btn__to_home"
              value="Iniciar sesión" />
        </div>
      </form>
    </main>

    <footer class="footer">
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>

  <script>
    document.getElementById('btn_redirect_to_home').addEventListener('click', () => {
      window.location.href = 'index.php';
    });
  </script>
</body>

</html>