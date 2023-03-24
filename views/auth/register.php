<div class="container register">
  <?php include_once __DIR__ . '/../templates/site-name.php' ?>

  <div class="container-sm">
    <p class="page-description">Crea tu cuenta en UpTask</p>

    <?php
    include_once __DIR__ . '/../templates/alerts.php';
    ?>

    <form class="form" method="POST" action="/register" novalidate>
      <div class="field">
        <label for="name">Nombre</label>
        <input type="name" name="name" id="name" placeholder="Nombre" value="<?php echo $user->name ?>">
      </div>

      <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $user->email ?>">
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">
      </div>
      <div class="field">
        <label for="password">Repetir Password</label>
        <input type="password" name="password2" id="password2" placeholder="Repite tu Password">
      </div>

      <input type="submit" id="boton" value="Iniciar Sesión">
    </form>


    <div class="actions">
      <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
      <a href="/forgot-password">¿Olvidaste tu Password?</a>
    </div>
  </div>
</div>