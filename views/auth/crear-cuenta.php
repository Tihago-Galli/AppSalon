<h1 class="nombre__app">Crear Cuenta</h1>

<div class="descripcion__app">
<p>Ingresa tus datos para crear una cuenta</p>
</div>
<form class="formulario" method="POST" action="/crear-cuenta">
<div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="Tu nombre" name="nombre" id="nombre">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" placeholder="Tu Apellido" name="apellido" id="apellido">
    </div>
    <div class="campo">
        <label for="numero">Numero</label>
        <input type="number" placeholder="Tu Numero" name="numero" id="numero">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" name="email" id="email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
    </div>
    <input type="submit" class="boton" value="Crear Cuenta">
</form>
<div class="acciones">
<p>¿Ya tienes una cuenta? <a href="/">Iniciar Sesion</a></p>
<a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>