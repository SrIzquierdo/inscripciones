        <main>
            <form action="?&metodo=generarPDF" method="post">
                <h2>Lista de Actividades:</h2>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
                <ul>
                    <?php foreach($datos as $actividad){ ?>
                        <li>
                            <input type="checkbox" id="<?php echo $actividad['nombre']; ?>" name="actividad[]" value="<?php echo $actividad['nombre']; ?>">
                            <label for="<?php echo $actividad['nombre']; ?>"><?php echo $actividad['nombre']; ?></label>
                        </li>
                    <?php } ?>
                </ul>
                <input type="submit" value="Descargar PDF">
            </form>
        </main>
    </body>
</html>