        <main class="contenedor">
            <h2>Clase: <?php echo $datos[0]['clase']; ?> <a href="?controlador=Clase&metodo=vistaDatosClase">Datos de la clase</a></h2>
            <?php if(file_exists("classes/".$datos[0]['clase']."Imagen.jpg")){ ?>
            <img src="classes/<?php echo $datos[0]['clase']; ?>Imagen.jpg">
            <?php } ?>
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