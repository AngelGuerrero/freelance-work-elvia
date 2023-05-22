<?= view('partials/user_panel_header.php'); ?>

<main class="main">
  <h1>Listado de Usuarios</h1>

  <div class="container">
    <?php if (isset($users) && !empty($users)): ?>
      <table class="users__table">
        <thead class="users__thead">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="users__tbody">
          <?php foreach ($users as $user): ?>
            <tr>
              <td>
                <?= $user['id']; ?>
              </td>
              <td>
                <?= $user['name']; ?>
              </td>
              <td>
                <?= $user['email']; ?>
              </td>
              <td>
                <form action="users/delete/<?= $user['id']; ?>" method="post">
                  <input type="hidden" name="_method" value="DELETE" />
                  <input type="submit" value="Eliminar" />
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay usuarios registrados.</p>
    <?php endif; ?>
</main>
</div>

<?= view('partials/user_panel_footer.php'); ?>