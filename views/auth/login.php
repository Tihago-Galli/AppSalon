<h1 class="nombre__app">Login</h1>

<div class="descripcion__app">
<p>Inicia sesion</p>
<p>O</p>
<p>Crea una cuenta si aun no estas registrado</p>
</div>
<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" name="email" id="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
    </div>
    <input type="submit" class="boton" value="Iniciar Secion">
</form>
<div class="acciones">
<p>¿Aun no tenes una cuenta? <a href="/crear-cuenta">Crear Cuenta</a></p>
<a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>
