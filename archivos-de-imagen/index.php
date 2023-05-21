<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener el nombre enviado desde el formulario
  $nombre = $_POST['nombre'];

  // Crear una imagen en blanco
  $imagen = imagecreatetruecolor(400, 200);

  // Definir los colores a utilizar
  $colorFondo = imagecolorallocate($imagen, 255, 255, 255); // Blanco
  $colorTexto = imagecolorallocate($imagen, 0, 0, 0); // Negro

  // Rellenar el fondo de la imagen
  imagefill($imagen, 0, 0, $colorFondo);

  // Escribir el nombre en la imagen
  $fuente = './Roboto-Regular.ttf'; // Ruta a un archivo de fuente TrueType (ttf)
  imagettftext($imagen, 40, 0, 50, 100, $colorTexto, $fuente, $nombre);

  // Establecer la cabecera de la imagen
  header('Content-Type: image/png');

  // Guardar la imagen en un archivo
  imagepng($imagen, 'imagen.png');

  // Liberar memoria
  imagedestroy($imagen);

  // Re-direccionar al archivo de imagen creado
  header('Location: imagen.png');
  exit;
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Generador de imagen</title>
</head>

<body>
  <form method="POST" action="">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <button type="submit">Generar imagen</button>
  </form>
</body>

</html>