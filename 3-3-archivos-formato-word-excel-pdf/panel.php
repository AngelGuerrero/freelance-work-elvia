<?php
require 'vendor/autoload.php';

session_start();

$message_time_passed = '';
$message_upload_file = '';

$array_files_list = array();

$session_user_data = file_exists('session_user_data.json') ? json_decode(file_get_contents('session_user_data.json'), true)[0] : array();

/**
 * Valida si hay una sesión iniciada y carga los datos del archivo users.json
 */
if (isset($session_user_data) && !empty($session_user_data)) {
  $email = $session_user_data['email'];

  $users_array = file_exists('users.json') ? json_decode(file_get_contents('users.json'), true) : array();

  if (is_array($users_array) && count($users_array) > 0) {
    $user = array_filter($users_array, function ($user) use ($email) {
      return $user['email'] === $email;
    });

    $session_user_data = array_shift($user);

    // Guarda los datos del usuario en un archivo word
    $json = '{
      "title": "Datos del usuario",
      "name": "' . $session_user_data['name'] . '",
      "email": "' . $session_user_data['email'] . '"
    }';
    $directory = './files/' . $session_user_data['email'] . '/';
    json_to_word($json, "Datos del usuario", 'datos_usuario.doc', $directory);
    json_to_excel($json, "Datos del usuario", 'datos_usuario.xls', $directory);
    json_to_pdf($json, "Datos del usuario", 'datos_usuario.pdf', $directory);
  }
}


/**
 * Cierra la sesión del usuario
 */
if (isset($_POST['logout'])) {

  if (isset($session_user_data['email'])) {
    $cookie_start_date_name = explode('@', $session_user_data['email'])[0];
    setcookie($cookie_start_date_name, '', time() - 3600);
    unset($_SESSION['session_user_data']);
    if (file_exists('session_user_data.json')) {
      unlink('session_user_data.json');
    }
  }

  header('Location: index.php');
  exit;
}

/**
 * Valida si el usuario ha iniciado sesión y muestra sus datos
 */
if (!empty($session_user_data)) {
  $cookie_start_date_name = explode('@', $session_user_data['email'])[0];
  $date_time_start = isset($_COOKIE[$cookie_start_date_name]) ? $_COOKIE[$cookie_start_date_name] : '';

  if (!empty($date_time_start)) {
    $time_passed = strtotime(date('Y-m-d H:i:s')) - strtotime($date_time_start);
  }

  $message_time_passed = "Sesión activa hace $time_passed segundos";
} else {
  header('Location: index.php');
  exit;
}

/**
 * Sube un archivo al servidor
 */
if (isset($_POST['upload_file_action']) && !empty($_FILES['file'])) {
  $file_name = $_FILES['file']['name'];
  $file_temp = $_FILES['file']['tmp_name'];

  // Crea el directorio para el usuario
  $new_directory = './files/' . $session_user_data['email'] . '/';
  if (!is_dir($new_directory)) {
    if (mkdir($new_directory, 0777, true)) {
      $message_upload_file = "El directorio se ha creado correctamente.";
    } else {
      $message_upload_file = "Ha ocurrido un error al crear el directorio.";
    }
  }

  // Sube el archivo al directorio del usuario
  if (move_uploaded_file($file_temp, $new_directory . $file_name)) {
    $message_upload_file = "El archivo se ha subido correctamente.";
  } else {
    $message_upload_file = "Hubo un error al subir el archivo.";
  }

  setcookie('message_upload_file', $message_upload_file, time() + 3600);
  header('Location: panel.php');
}

/**
 * Limpia el mensaje para el usuario
 */
if (isset($_COOKIE['message_upload_file'])) {
  $message_upload_file = $_COOKIE['message_upload_file'];
  setcookie('message_upload_file', '', time() - 3600);
}

/** 
 * Lista los archivos del usuario
 */
if (isset($session_user_data) && !empty($session_user_data['email'])) {
  $directory = './files/' . $session_user_data['email'] . '/';

  // Obtener todos los archivos y directorios en el directorio especificado
  if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
  }

  $files_list = scandir($directory);

  // Iterar sobre los archivos y filtrar los directorios "." y ".."
  foreach ($files_list as $file) {
    if ($file != '.' && $file != '..') {
      array_push($array_files_list, $file);
    }
  }
}

/**
 * Elimina un archivo del servidor
 */
if (isset($_POST['delete_file_action']) && !empty($_POST['file_name'])) {
  $directory = './files/' . $session_user_data['email'] . '/' . $_POST['file_name'];

  if (file_exists($directory)) {
    if (unlink($directory)) {
      $message_upload_file = "El archivo se ha eliminado correctamente.";
    } else {
      $message_upload_file = "Ha ocurrido un error al eliminar el archivo.";
    }
  } else {
    $message_upload_file = "El archivo no existe.";
  }

  setcookie('message_upload_file', $message_upload_file, time() + 3600);
  header('Location: panel.php');
}

/** 
 * Función para convertir JSON a documento Word
 */
function json_to_word($json, $doc_title, $file_name, $directory)
{
  // Decodifica el JSON como un array asociativo
  $data = json_decode($json, true);

  // Generar el contenido del documento Word
  $content = '<html xmlns:w="urn:schemas-microsoft-com:office:word"
  xmlns="http://www.w3.org/TR/REC-html40">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Documento Word</title>
  </head>
  <body>
    <h1>' . $data['title'] . '</h1>
    <p>' . 'Nombre: ' . $data['name'] . '</p>
    <p>' . 'Email: ' . $data['email'] . '</p>
  </body>
  </html>';

  if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
  }

  $full_path = $directory . $file_name;
  file_put_contents($full_path, $content);
}

/** 
 * Función para convertir JSON a documento Excel
 */
function json_to_excel($json, $doc_title, $file_name, $directory)
{
  // Decodifica el JSON como un array asociativo
  $data = json_decode($json, true);

  // Generar el contenido del documento Excel
  $content = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns="http://www.w3.org/TR/REC-html40">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Documento Excel</title>
  </head>
  <body>
    <h1>' . $data['title'] . '</h1>
    <p>' . 'Nombre: ' . $data['name'] . '</p>
    <p>' . 'Email: ' . $data['email'] . '</p>
  </body>
  </html>';

  if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
  }

  $full_path = $directory . $file_name;
  file_put_contents($full_path, $content);
}

/**
 * Función para convertir JSON a documento PDF
 */
function json_to_pdf($json, $doc_title, $file_name, $directory)
{
  // Decodificar el JSON a un array asociativo
  $data = json_decode($json, true);

  // Crear una instancia de TCPDF
  $pdf = new TCPDF();

  // Agregar una página
  $pdf->AddPage();

  // Establecer el tamaño y tipo de fuente
  $pdf->SetFont('helvetica', '', 12);

  // Agregar contenido al PDF desde el JSON
  $pdf->Write(10, $data['title'], '', 0, 'C', true);
  $pdf->Ln(5);
  $pdf->Write(10, 'Nombre: ' . $data['name'], '', 0, 'L', true);
  $pdf->Write(10, 'Email: ' . $data['email'], '', 0, 'L', true);

  if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
  }

  // Generar el contenido del PDF como cadena
  $pdf = $pdf->Output('', 'S');

  // Guardar el contenido del PDF en un archivo en el servidor
  $filePath = $directory . $file_name;
  file_put_contents($filePath, $pdf);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Archivos en formato word, excel y pdf</title>

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