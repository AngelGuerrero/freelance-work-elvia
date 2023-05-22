<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de control</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
</head>

<body>
    <h1>Panel de control</h1>
    <p>
        <a href="<?php echo base_url('users/') ?>">Listado de usuarios</a>
        <br />
        <a href="<?php echo base_url('users/new') ?>">Crear nuevo usuario</a>
    </p>

    <br>

    <!-- muestra mensaje de error -->
    <?php if (session()->has('error')): ?>
        <p style="color: red;">
            <?php echo session('error'); ?>
        </p>
    <?php elseif (session()->has('message')): ?>
        <p style="color: green;">
            <?php echo session('message'); ?>
        </p>
    <?php endif ?>

    <!-- Verificar si tiene sesion iniciada -->
    <?php if (session()->has('user')): ?>
        <p>Bienvenido
            <?php echo session('user'); ?>
        </p>
        <a href="<?php echo base_url('auth/logout') ?>">Cerrar sesión</a>
    <?php else: ?>

        <!-- iniciar sesión -->
        <section>
            <h2>Iniciar sesión</h2>
            <form action="<?php echo base_url('auth/login') ?>" method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required />
                <br />
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required />
                <br />
                <input type="submit" value="Iniciar sesión" />
            </form>
        </section>

    <?php endif; ?>

</body>

</html>