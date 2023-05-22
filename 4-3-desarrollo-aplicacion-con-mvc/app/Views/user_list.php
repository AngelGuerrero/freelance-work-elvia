<?= view('partials/user_panel_header.php'); ?>

<main class="main">
  <h1>Listado de Usuarios</h1>

  <?php if (isset($users) && !empty($users)): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Correo Electrónico</th>
        </tr>
      </thead>
      <tbody>
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
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No hay usuarios registrados.</p>
  <?php endif; ?>
</main>

<?= view('partials/user_panel_footer.php'); ?>