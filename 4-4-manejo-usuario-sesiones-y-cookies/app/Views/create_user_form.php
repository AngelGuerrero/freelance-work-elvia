<?= view('partials/user_panel_header.php'); ?>

<main class="main">
  <form action="create" class="form" method="post">
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
      <input type="password" class="form__input" name="password" required />
    </div>

    <!-- Submit -->
    <div class="form__control--submit">
      <input type="submit" name="create_user_form" class="form__submit" value="Crear cuenta" />
      <input id="btn_redirect_to_home" type="button" name="create_user" class="btn__to_home" value="Iniciar sesión" />
    </div>
  </form>
</main>

<?= view('partials/user_panel_footer.php'); ?>