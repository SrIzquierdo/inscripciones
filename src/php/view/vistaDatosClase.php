        <main class=contenedor>
            <h1>
            <?php echo $datos['nombre']; ?>
            </h1>
            <div id="divImagenClase">
            <?php if(file_exists("classes/".$datos['nombre']."Imagen.jpg")){echo '<img src="classes/'.$datos['nombre'].'Imagen.jpg">';}else{echo '<p>Sin imagen</p>';} ?>
            </div>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Clase&metodo=modificarImagenClase" enctype="multipart/form-data" method="post">
                <input type="hidden" name="nombreClase" value="<?php echo $datos['nombre']; ?>">
                <p>
                    <label for="imagenClase"><?php if(file_exists("classes/".$datos['nombre']."Imagen.jpg")){echo 'Modificar';}else{echo 'Añadir';} ?> la imagen de la clase</label>
                    <input type="file" name="imagenClase" id="imagenClase" accept="image/*">
                </p>
                <input type="submit" value="<?php if(file_exists("classes/".$datos['nombre']."Imagen.jpg")){echo 'Modificar';}else{echo 'Añadir';} ?>">
                <?php if(file_exists("classes/".$datos['nombre']."Imagen.jpg")){?> <a href="?controlador=Clase&metodo=eliminarImagen&clase=<?php echo $datos['nombre']; ?>" class=submit>Eliminar</a> <?php } ?>
            </form>
        </main>
    </body>
</html>