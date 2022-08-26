<h1 class="nombre__app">Olvide mi contraseña</h1>

<div class="descripcion__app">
<p>Ingresa tu correo electronico para enviarte un email de recuperacion</p>
</div>
<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" name="email" id="email">
    </div>
    <input type="submit" class="boton" value="Enviar correo">
</form>
<div class="acciones">
<p>¿Ya tienes una cuenta? <a href="/">Iniciar Sesion</a></p>
<p>¿Aun no tenes una cuenta? <a href="/crear-cuenta">Crear Cuenta</a></p>
</div>