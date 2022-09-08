<h1 class="nombre__app">Bienvenido a AppSalon</h1>

<div class="descripcion__app">

<p>Inicia sesion para reservar una cita</p>

</div>

<?php 

include_once __DIR__ . '/../templates/alertas.php';

?>

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
