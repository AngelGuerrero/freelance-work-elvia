<?php
include_once 'common.php';

session_start();
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
        <h2 class="title"> Gestor de archivos </h2>
        <div class="table__header">

          <!-- formulario para subir archivo -->
          <form action="panel.php" method="post" enctype="multipart/form-data" class="form__upload_file">
            <div class="form__control--submit">
              <input type="file" name="file" id="form_file">
              <input type="submit" name="upload_file_action" class="btn--upload-file" value="Subir archivo" />
            </div>
          </form>
        </div>

        <div class="table__columns table__titles">
          <div class="table__column">
            <p class="table__column--title">Nombre archivo</p>
          </div>
          <div class="table__column">
            <p class="table__column--title">Acción</p>
          </div>
        </div>

        <?php foreach ($array_files_list as $file): ?>
          <div class="table__columns">
            <div class="table__column">
              <p class="table__column--text">
                <?php echo $file; ?>
              </p>
            </div>
            <div class="table__column--action">
              <p class="table__column--text">
                <a href="<?php echo './files/' . $session_user_data['email'] . '/' . $file; ?>" target="_blank"
                    class="btn--download-file">Descargar</a>
              </p>

              <form action="panel.php" method="post">
                <input type="hidden" name="file_name" value="<?php echo $file; ?>">
                <input type="submit" name="delete_file_action" class="btn--delete-file" value="Eliminar" />
              </form>
            </div>
          </div>
        <?php endforeach; ?>
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