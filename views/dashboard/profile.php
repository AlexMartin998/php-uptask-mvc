<?php include_once __DIR__ . '/../dashboard/header-dashboard.php' ?>


<div class="container-sm">
  <?php include_once __DIR__ . '/../templates/alerts.php' ?>

  <a href="/cambiar-password" class="anchor">Cambiar Password</a>

  <form class="form" method="POST" action="/perfil">
    <div class="field">
      <label for="name">Nombre</label>
      <input type="text" value="<?php echo $user->name; ?>" name="name" placeholder="Tu Nombre" />
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" value="<?php echo $user->email; ?>" name="email" placeholder="Tu Email" />
    </div>

    <input type="submit" value="Guardar Cambios">
  </form>

</div>


<?php include_once __DIR__ . '/../dashboard/footer-dashboard.php' ?>