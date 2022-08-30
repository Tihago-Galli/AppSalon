<?php

namespace Model;


class Usuario extends ActiveRecord {

//base de datos

protected static $tabla = 'usuarios';
protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

public $id;
public $nombre;
public $apellido;
public $email;
public $password;
public $telefono;
public $admin;
public $confirmado;
public $token;


public function __construct($args = [])
{
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->admin = $args['admin'] ?? 0;
    $this->confirmado = $args['confirmado'] ?? 0;
    $this->token = $args['token'] ?? '';


}

//mensajes de validacion para crear una cuenta
public function validarNuevaCuenta(){
    if(!$this->nombre){
        //el doble corchete es por que esta creadno un arrays dentro del arrays error
    
       self::$alertas['error'][] = "Debes ingrasar un nombre";
    }
    if(!$this->apellido){
        
       self::$alertas['error'][] = "Debes ingrasar un apellido";
    }
    if(!$this->telefono){
        
       self::$alertas['error'][] = "Debes ingrasar un telefono";
    }
    if(!$this->email){
        
       self::$alertas['error'][] = "Debes ingrasar un email";
    }
    if(!$this->password){
        
       self::$alertas['error'][] = "Debes ingrasar un contraseña";
    }
    if(strlen($this->password)< 8 ){
        
      self::$alertas['error'][] = "La contraseña debe contener al menos 8 caracteres";
   }

    return self::$alertas;
}

public function validarCorreo(){
   $query = "SELECT * FROM ". static::$tabla. " WHERE email = '".$this->email."' LIMIT 1";


   $resultado = self::$db->query($query);

 if($resultado->num_rows){
      self::$alertas['error'][]="El usuario ya esta registrado";
 }

 return $resultado;
}
//Hashear password
public function hashPassword(){
   $this->password = password_hash($this->password, PASSWORD_BCRYPT);
}

public function crearToken(){
   $this->token = uniqid();
}


}

?>