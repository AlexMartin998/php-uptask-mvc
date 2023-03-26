<?php include_once __DIR__ . '/../dashboard/header-dashboard.php' ?>


<div class="container-sm">
  <?php include_once __DIR__ . '/../templates/alerts.php' ?>

  <a href="/perfil" class="anchor">Volver al Perfil</a>


  <form class="form" method="POST" action="/cambiar-password">
    <div class="field">
      <label for="password2">Password Actual</label>
      <input type="password" name="password2" placeholder="Tu Password Actual" />
    </div>
    <div class="field">
      <label for="new_password">Nuevo Password</label>
      <input type="password" name="new_password" placeholder="Tu Nuevo Password" />
    </div>

    <input type="submit" value="Guardar Cambios">
  </form>

</div>


<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php' ?>