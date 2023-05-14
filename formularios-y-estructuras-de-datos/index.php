<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formularios y estructuras de datos en PHP</title>

  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <nav class="nav">
      <h2 class="nav__title">¡Hola, bienvenida!</h2>
    </nav>

    <main class="main">
      <!-- Imprime el formulario principal -->
      <?php echo file_get_contents('./form.html'); ?>

      <?php
      $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
      $categorias = isset($_POST['categorias']) ? $_POST['categorias'] : array();
      $email = isset($_POST['email']) ? $_POST['email'] : '';

      if (empty($genero)) {
        return;
      }

      if (empty($categorias)) {
        return;
      }

      if (empty($email)) {
        return;
      }

      echo "<div class='container__result'> ";
      echo "
        <strong>Estos son los datos que hemos recibido:</strong> 
        <br> 
        <br> 
        <strong>Género:</strong> $genero
        <br> 
        <br>";
      echo "<strong>Categorías:</strong> <br>";
      foreach ($categorias as $categoria) {
        echo "- $categoria <br>";
      }
      echo "<br> <strong>Email:</strong> $email";
      echo "</div>";
      ?>
    </main>
  </div>
</body>

</html>