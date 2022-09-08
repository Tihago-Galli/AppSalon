<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginControllers{
    public static function login(Router $router){

        $alertas = [];
        
        if( $_SERVER['REQUEST_METHOD'] === 'POST'){{
        

            $auth = new Usuario($_POST);
           $alertas = $auth->validarLogin();

           if(empty($alertas)){
            $usuario = Usuario::where('email', $auth->email);

            if($usuario){
               if($usuario->validarPasswordAndVerificar($auth->password)){
                    session_start();

                    //llenamos la sesion con los datos del usuario una vez autentificado
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;
                    
                    //redireccionamos al usuario segun su rol
                    if($usuario->admin === '1'){
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    }else{
                        header('Location: /citas');
                    }
               }
            }else{
                Usuario::setAlerta('error', 'El Email es invalido');
            }
           }
        }};

        $alertas = Usuario::getAlertas();
       $router->render('auth/login',[
        'alertas' => $alertas
       ]);
    }


//vaciamos la session con los datos del usuario y lo redireecionamos al inicio
    public static function logout(){
        session_start();

        $_SESSION = [];

        header('Location: /');
    }

    
    public static function olvide(Router $router){

        $alertas = [];

        if( $_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

        //vamidamos que el usuario ingrese un email
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                //validamos de que el usuario haya ingreado un correo valio y que este confirmado
                if($usuario && $usuario->confirmado === '1'){

                    //Generar Token 
                    $usuario->crearToken();
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->restablecerPassword();
                    Usuario::setAlerta('exito','Se ha enviado un email a tu correo');
                }else{
                    Usuario::setAlerta('error','Ese Email no esta registrado o aun no se ha confimado');
                 
                }
            }
        };
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error',"correo no valido");
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer la nueva contraseña y actualizarla
            $password = new Usuario($_POST);

            $password->validarPassword();

            if(empty($alertas)){

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/restablecer-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
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