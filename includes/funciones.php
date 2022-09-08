<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function iniciarSession() {
    if(!isset($_SESSION)){
        session_start();
    }  
}

//Funcion que revisa si el usuario esta logueado

function isAuth(): void{

    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}