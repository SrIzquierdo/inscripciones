    <?php
    // Agrupar datos por clase
    $clases = array();
    foreach ($datos as $fila) {
        $clase = $fila['clase'];
        if (!isset($clases[$clase])) {
            $clases[$clase] = array();
        }
        $clases[$clase][] = $fila;
    }

    // Mostrar contenido por cada clase
    foreach ($clases as $clase => $alumnosClase) {
        ?>
        <main class="contenedor">
        <h2>Clase: <?php echo $clase; ?></h2>
        <?php
        // Separar alumnos inscritos de los no inscritos
        $actividades = array();
        $no_inscritos = array();

        foreach ($alumnosClase as $fila) {
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
                ?>
            </table>
            <?php
        }

        // Mostrar tabla de alumnos no inscritos
        ?>
        <table>
            <caption><h3>No Inscritos</h3></caption>
            <?php
            foreach ($no_inscritos as $alumno) {
                echo "<tr><td>$alumno</td></tr>";
            }
            ?>
        </table>
        </main>
        <?php
    }
    ?>
</body>
</html>