        <main class="contenedor">
            <h2>Clase: <?php echo $datos[0]['clase']; ?></h2>
            <?php
            // Separar alumnos inscritos de los no inscritos
            $actividades = array();
            $no_inscritos = array();

            foreach($datos as $fila) {
                if ($fila['actividad']) {
                    $actividades[$fila['actividad']][] = $fila['alumno'];
                } else {
                    $no_inscritos[] = $fila['alumno'];
                }
            }

            // Mostrar tablas de alumnos inscritos por actividad
            foreach ($actividades as $actividad => $alumnos) {
                ?>
                <table>
                    <caption><h3><?php echo $actividad; ?></h3></caption>
                <?php
                foreach ($alumnos as $alumno) {
                    echo "<tr><td>$alumno</td></tr>";
                }
                ?></table><?php
            }

            // Mostrar tabla de alumnos no inscritos
            ?>
            <table>
                <caption><h3>No Inscritos</h3></caption>
            <?php
            foreach ($no_inscritos as $alumno) {
                echo "<tr><td>$alumno</td></tr>";
            }
            ?></table>
        </main>
    </body>
</html>