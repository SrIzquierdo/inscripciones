<?php
    require_once 'php/config/config.php';
    $ruta = RutaPorDefecto;
    $controlador = ControladorPorDefecto;
    $metodo = MetodoPorDefecto;

    /* Pregunta si existe el controlador enviado por $_GET['controlador'] */
    if(isset($_GET['controlador'])){
        $ruta=strtolower($_GET['controlador']);
        $controlador=$_GET['controlador'];
    }
    require 'php/controller/'.$ruta.'.php';
    $Control = new $controlador();
    
    /*  Pregunta si existe el método enviado por $_GET['metodo'] y guarda los datos retornados en $datos */
    if(isset($_GET['metodo'])){
        $metodo = $_GET['metodo'];
    }
    $datos=$Control->{$metodo}();

    /* Mostrar la vista */
    include 'php/view/template/cabecera.php';
    include 'php/view/'.$Control->vista.'.php';