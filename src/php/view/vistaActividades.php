        <main class="contenedor">
            <?php 
                if($Control->mensaje){
                    echo '<h2>'.$Control->mensaje.'</h2>';
                }
            ?>
            <table class="alumnos">
                <tr>
                    <th>Actividad</th>
                    <th>Max Alumnos</th>
                    <th></th>
                </tr>
                <?php
                    foreach($datos as $fila){
                    ?>
                        <tr>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['nMaxAlumnos']; ?></td>
                            <td><a href="?controlador=Controlador&metodo=vistaInscribir&actividad=<?php echo $fila['id']; ?>" class="inscribir">Inscribir</a></td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
        </main>
    </body>
</html>