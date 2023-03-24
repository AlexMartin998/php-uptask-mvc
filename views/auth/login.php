<div class="container login">
  <h1 class="uptask">UpTask</h1>
  <p class="tagline">Crea y Administra tus Proyectos</p>

  <div class="container-sm">
    <p class="page-description">Iniciar Sesión</p>

    <form class="form" method="POST" action="/" novalidate>
      <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email">
      </div>

      <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">
      </div>

      <input type="submit" id="boton" value="Iniciar Sesión">
    </form>


    <div class="actions">
      <a href="/register">¿Aún no tienes una cuenta? obtener una</a>
      <a href="/forgot-password">¿Olvidaste tu Password?</a>
    </div>
  </div>
</div>