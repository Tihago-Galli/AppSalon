<?php

namespace Controllers;

use MVC\Router;

class citaControllers{
    public static function index(Router $router){

        iniciarSession();
        
        isAuth();
        
        $router->render('citas/citas',[
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']

        ]);
    }
}
?>
