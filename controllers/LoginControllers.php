<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginControllers{
    public static function login(Router $router){
       $router->render('auth/login');
    }
    public static function logout(){
        echo "desde logout";
    }
    public static function olvide(Router $router){
        $router->render('auth/olvide-password',[]);
    }

    public static function recuperar(){
        echo "desde recuperar";
    }
    public static function crear(Router $router){

            $usuario = new Usuario;
            $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            //sincroniza el objeto en memoria con los datos que agreggo el usuario
            //para rellenar el formualio en caso de que tenga algun error y no tenga que volver a llenar todos los campos
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();
            
            //revisamos de que alertas este vacia
            if(empty($alertas)){
               $resultado = $usuario->validarCorreo();

               if($resultado->num_rows){
                $alertas = Usuario::getAlertas();    
               }else{
                //Hashear la contraseña del usuario
                $usuario->hashPassword();
        
                $usuario->crearToken();

           

                //enviar email

                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarEmail();

                    $resultado = $usuario->guardar();
                        
       
                    if($resultado){
                        header('Location: /mensaje');
                    }

                   
                
               }
            }
        }
       $router->render('auth/crear-cuenta',[
        'usuario' => $usuario,
        'alertas' => $alertas
       ]);
    }
   
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){

        $alertas = [];
        
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
                Usuario::setAlerta('error','Token no valido');
        }else{

            $usuario->confirmado = '1';
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito','Tu cuenta a sido confirmada');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas

        ]);
    }
}
?>