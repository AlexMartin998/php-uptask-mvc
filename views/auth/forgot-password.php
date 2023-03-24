<div class="container forgot-password">
  <?php include_once __DIR__ . '/../templates/site-name.php' ?>

  <div class="container-sm">
    <p class="page-description">Recupera tu Acceso UpTask</p>

    <form class="form" method="POST" action="/forgot-password" novalidate>

      <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email">
      </div>

      <input type="submit" id="boton" value="Enviar Instrucciones">

    </form>


    <div class="actions">
      <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
      <a href="/register">¿Aún no tienes una cuenta? obtener una</a>
    </div>
  </div>
</div>