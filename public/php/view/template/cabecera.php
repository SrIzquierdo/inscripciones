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
                    if($Control->vista == 'vistaFormularioPDF'){
                        ?>
                        <a href="?metodo=vistaInscripciones">Inscripciones</a>
                <?php }
                    elseif($Control->vista == 'vistaTablaInscripciones'){
                        ?>
                        <a href="?metodo=vistaDescargarPDF">Descargar en PDF</a>
                <?php } ?>
                </nav>
            </div>
        </header>