        <main class="formAlumnos">
            <h1>Tus alumnos</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Sesion&metodo=generarClaseAlumnos" method="post">
                <input type="hidden" name="nombreClase" value="<?php echo $datos['clase']; ?>">
                <input type="hidden" name="nAlumnos" value="<?php echo $datos['nAlumnos']; ?>">
                <?php
                    for ($i=0; $i<$datos['nAlumnos']; $i++) { 
                        ?>
                        <div>
                            <p>
                                <input type="text" name="alumnos[<?php echo $i; ?>][nombre]" placeholder="Nombre del alumno">
                            </p>
                            <div>
                                <label for="m<?php echo $i; ?>">M</label>
                                <input type="radio" name="alumnos[<?php echo $i; ?>][genero]" id="m<?php echo $i; ?>" checked value="m">
                            </div>
                            <div>
                                <label for="f<?php echo $i; ?>">F</label>
                                <input type="radio" name="alumnos[<?php echo $i; ?>][genero]" id="f<?php echo $i; ?>" value="f">
                            </div>
                        </div>
                        <?php
                    }
                ?>
                <input type="submit" value="Enviar">
            </form>
        </main>
    </body>
</html>