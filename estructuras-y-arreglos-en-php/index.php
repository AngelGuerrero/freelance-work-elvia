<?php
session_start();

class User
{
  public $name;
  public $email;
  public $password;
  public $birthday;
  public $colors;

  public function __construct($name, $email, $password, $birthday, $colors)
  {
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->birthday = $birthday;
    $this->colors = $colors;
  }
}

$COOKIE_TIME = time() + 3600;

$message_error = '';

$user1 = new User('Elvia', 'elvia@test.com', '123456', '2023-05-16 07:43:51', []);
$user2 = new User('Luis', 'luis@test.com', 'master', '2023-05-16 07:43:51', []);
$user3 = new User('María', 'maria@test.com', 'maria', '2023-05-16 07:43:51', []);

$users = [$user1, $user2, $user3];

/**
 * Obtiene los datos enviados por el usuario
 */
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
$colors = isset($_POST['colors']) ? $_POST['colors'] : array();

/**
 * Inicia la sesión del usuario y guarda sus datos
 */
if (isset($_POST['login'])) {
  $find_user = array_search($email, array_column($users, 'email')) && array_search($password, array_column($users, 'password'));
  if ($find_user) {
    $message_error = '';

    // Guarda los datos del usuario en la sesión
    $session_user_data = [
      'email' => $email,
      'password' => $password,
      'birthday' => $birthday,
      'colors' => $colors
    ];
    $_SESSION['session_user_data'] = $session_user_data;

    // Obtiene la fecha y hora actual
    $date_time_start = date('Y-m-d H:i:s');

    // Crea la cookie con la fecha y hora de inicio de sesión
    setcookie('start_date', $date_time_start, $COOKIE_TIME);
  } else {
    $message_error = 'El email o la contraseña son incorrectos';
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
  <title>Estructuras y arreglos en PHP</title>

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

        <!-- Colors -->
        <div class="form__control">
          <label for="colors" class="form__label">Colores favoritos:</label>
          <select name="colors[]" multiple required>
            <option value="red">Rojo</option>
            <option value="blue">Azul</option>
            <option value="green">Verde</option>
            <option value="yellow">Amarillo</option>
          </select>
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