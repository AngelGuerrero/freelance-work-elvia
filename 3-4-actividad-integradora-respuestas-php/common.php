<?php
require 'vendor/autoload.php';

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
  $file_path = $directory . $file_name;
  file_put_contents($file_path, $pdf);
}

/**
 * Función para convertir JSON a una imagen
 */
function json_to_image($text, $doc_title, $file_name, $directory)
{
  // Crear una imagen en blanco
  $image = imagecreatetruecolor(400, 200);

  // Definir los colores a utilizar
  $background = imagecolorallocate($image, 255, 255, 255); // Blanco
  $color_text = imagecolorallocate($image, 0, 0, 0); // Negro

  // Rellenar el fondo de la imagen
  imagefill($image, 0, 0, $background);

  // Ruta a un archivo de fuente TrueType (ttf)
  $font = './Roboto-Regular.ttf';
  // Escribir el nombre en la imagen
  imagettftext($image, 40, 0, 50, 100, $color_text, $font, $text);

  // Establecer la cabecera de la imagen
  $file_path = $directory . $file_name;

  // Guardar la imagen en un archivo
  imagepng($image, $file_path);

  // Liberar memoria
  imagedestroy($image);
}