<div class="container reset-password">
  <?php include_once __DIR__ . '/../templates/site-name.php' ?>

  <div class="container-sm">
    <p class="page-description">Coloca tu nuevo Password</p>

    <?php include_once __DIR__ . '/../templates/alerts.php' ?>


    <?php if (!$hasError) { ?>

      <form class="form" method="POST" novalidate>

        <div class="field">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Password">
        </div>

        <input type="submit" id="boton" value="Guardar Password">
      </form>

    <?php } ?>



    <div class="actions">
      <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
      <a href="/register">¿Aún no tienes una cuenta? obtener una</a>
    </div>
  </div>
</div>