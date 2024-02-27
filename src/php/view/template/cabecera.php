<!DOCTYPE html>
<html>
    <head>
        <title>Inscripciones</title>
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class="cabeceraIzquierda">
                <h1>Inscripciones Fiestas Escolares</h1>
            </div>
            <div class="cabeceraDerecha">
                <nav>
                    <?php
                        if(isset($_SESSION['id'])){
                            ?>
                            <a href="?controlador=Controlador&metodo=vistaClase" class="verTabla">Clase</a>
                            <a href="?controlador=Controlador&metodo=vistaActividades" class="verTabla">Inscripciones</a>
                            <a href="?controlador=Sesion&metodo=cerrarSesion" class="botonSesion">Cerrar sesión</a>
                            <?php
                        }
                        else{
                            if($metodo == 'vistaRegistro'){
                                ?>
                                <a href="?controlador=Sesion&metodo=vistaSesion" class="botonSesion">Iniciar Sesión</a>
                                <?php
                            }
                            else{
                                ?>
                                <a href="?controlador=Sesion&metodo=vistaRegistro" class="botonSesion">Registrarse</a>
                                <?php
                            }
                        }
                    ?>
                </nav>
            </div>
        </header>