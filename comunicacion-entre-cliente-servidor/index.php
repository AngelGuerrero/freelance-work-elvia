<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Comunicación entre cliente y servidor</title>

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-size: medium;
      color: darkslategray;
    }

    .wrapper {
      display: grid;
      place-items: center;
      min-height: 100vh;
      background-color: #4158d0;
      background-image: linear-gradient(43deg,
          #4158d0 0%,
          #c850c0 46%,
          #ffcc70 100%);
    }

    .container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container__title {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 2rem;
    }

    .container__title--result {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 2rem;
      color: #fff;
    }

    .form {
      width: 400px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
    }

    .form__control {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-size: medium;
      color: darkslategray;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.8rem;
    }

    .form__label {
      width: 100px;
      text-align: right;
      margin-right: 10px;
      padding: 5px;
    }

    .form__input {
      width: 100%;
      height: 30px;
      border: 1px solid purple;
      border-radius: 5px;
      padding: 5px;
    }

    .form__submit {
      width: 100%;
      height: 30px;
      border: 1px solid purple;
      border-radius: 5px;
      padding: 5px;
      background-color: purple;
      color: #fff;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <?php
    $form = file_get_contents('./form.html');

    // Validaciones de entrada
    $hasName = isset($_GET['nombre']) && !empty($_GET['nombre']);
    $hasEdad = isset($_GET['edad']) && is_numeric($_GET['edad']);

    if (!$hasName || !$hasEdad) {
      echo $form;
      exit;
    }

    $nombre = $_GET['nombre'];
    $edad = $_GET['edad'];

    $message = '';

    if ($edad <= 30) {
      $message .= '¡Qué tal ' . $nombre . ', eres joven!';
    } else if ($edad >= 30 && $edad < 50) {
      $message .= '¡Hola ' . $nombre . ', ya eres un adulto!';
    } else {
      $message .= '¡Bienvenido ' . $nombre . ', eres un adulto mayor!';
    }
    echo '<h1 class="container__title--result">' . $message . '</h1>'
      ?>

  </div>
</body>

</html>