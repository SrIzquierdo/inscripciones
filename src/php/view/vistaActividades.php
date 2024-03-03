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
                    <th>Alumnos Inscritos</th>
                    <th></th>
                </tr>
                <?php
                foreach($datos['actividad'] as $actividad){
                    $alumnos_inscritos = 0;
                    foreach ($datos['alumnos'] as $inscripcion) {
                        if ($inscripcion['actividad'] == $actividad['id']) {
                            $alumnos_inscritos = $inscripcion['numero_alumnos_inscritos'];
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $actividad['nombre']; ?></td>
                        <td><?php echo $actividad['nMaxAlumnos']; ?></td>
                        <td><?php echo $alumnos_inscritos; ?></td>
                        <td><a href="?metodo=vistaInscribir&actividad=<?php echo $actividad['id']; ?>" class="inscribir"><?php 
                            if ($alumnos_inscritos > 0) {
                                echo 'Modificar';
                            }
                            else{
                                echo 'Inscribir';
                            }
                        ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </main>
    </body>
</html>