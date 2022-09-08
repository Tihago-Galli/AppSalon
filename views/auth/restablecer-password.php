<h1 class="nombre__app">Restablecer contraseña</h1>

<div class="descripcion__app">
<p>Ingresa una nueva contraseña</p>
</div>

<?php 

include_once __DIR__ . '/../templates/alertas.php';

?>
<?php if($error) return null; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Nueva Contraseña</label>
        <input type="password" placeholder="Nueva Contraseña" name="password" id="password">
    </div>
    <input type="submit" class="boton" value="Restablecer">
</form>
<div class="acciones">
<p>¿Ya tienes una cuenta? <a href="/">Iniciar Sesion</a></p>
<p>¿Aun no tenes una cuenta? <a href="/crear-cuenta">Crear Cuenta</a></p>
</div>