<?php
include_once 'common.php';

session_start();

$input_name = isset($_POST['input_name']) ? $_POST['input_name'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']) && !empty($input_name)) {
  // id random para nombre de archivo
  $id = rand(1, 1000000);

  $json = '{
    "title": "Datos del usuario",
    "name": "' . $input_name . '",
    "email": "' . $session_user_data['email'] . '"
  }';
  $directory = './files/' . $session_user_data['email'] . '/';
  json_to_word($json, "Datos del usuario", $id . '_documento.doc', $directory);
  json_to_excel($json, "Datos del usuario", $id . '_documento.xls', $directory);
  json_to_pdf($json, "Datos del usuario", $id . '_documento.pdf', $directory);
  json_to_image($input_name, "Datos del usuario", $id . '_documento.png', $directory);

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
  <title>Actividad Integradora. Respuestas en PHP</title>

  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="wrapper--login">
    <nav class="nav--login">
      <div class="menu__container">
        <h3 class="nav__title">
          Hola,
          <?php echo $session_user_data['name']; ?>
        </h3>

        <div class="menu__items">
          <a href="panel.php" class="btn--menu">Inicio</a>
          <a href="create_word_excel_pdf.php" class="btn--menu">Crear archivos en Word, Excel y Pdf</a>
        </div>
      </div>


      <div class="container__form--logout">
        <p>
          <?php echo $session_user_data['email']; ?>
        </p>
        <form action="panel.php" method="post">
          <div class="form__control--submit">
            <input type="submit" name="logout" class="btn btn--logout" value="Cerrar sesión" />
          </div>
        </form>
      </div>
    </nav>

    <main class="main">
      <?php if ($message_upload_file): ?>
        <div class="container__message">
          <p>
            <?php echo $message_upload_file; ?>
          </p>
        </div>
      <?php endif; ?>

      <div class="table">
        <h2 class="title">Generar archivos</h2>

        <p class="paragraph">
          Ingresa tu nombre para guardar en los documentos.
        </p>

        <div class="table__header">
          <!-- formulario para subir archivo -->
          <form action="create_word_excel_pdf.php" method="post" class="form__upload_file">
            <div class="form__control">
              <label for="input_name" class="form__label">Nombre:</label>
              <input type="text" name="input_name" class="form__input" id="input_name">
            </div>

            <div class="form__control">
              <div></div>
              <input type="submit" name="submit" class="btn__to_home" value="Enviar" />
            </div>
          </form>
        </div>

      </div>

    </main>

    <footer class="footer__panel">
      <p class="footer__text">
        <?php echo $message_time_passed; ?>
      </p>
      <p class="footer__text">Todos los derechos reservados &copy;</p>
    </footer>
  </div>
</body>

</html>