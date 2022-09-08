<?php 

namespace Model;


class Servicios extends ActiveRecord{

    public static $tabla = 'servicios';
    public static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($arry = [])
    {
        $this->id = $arry['id'] ?? '';  
        $this->nombre = $arry['nombre'] ?? '';  
        $this->precio = $arry['precio'] ?? '';        

    }
}

?>