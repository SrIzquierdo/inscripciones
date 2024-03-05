<?php 
    if($Control->mensaje){
        echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
    }
?>
<?php
// Agrupar los alumnos no inscritos
$alumnos_no_inscritos = array();
foreach ($datos as $actividad => $clases) {
    foreach ($clases as $clase => $alumnos) {
        foreach ($alumnos as $alumno) {
            if ($actividad === "") {
                $alumnos_no_inscritos[] = $alumno;
            }
        }
    }
}

// Eliminar los registros sin actividad
$datos = array_filter($datos, function($actividad) {
    return $actividad !== "";
}, ARRAY_FILTER_USE_KEY);

// Mostrar contenido por cada actividad
foreach ($datos as $actividad => $clases) {
    ?>
    <main class="contenedor">
    <h2><input type="checkbox" name="pdf[]" value="<?php echo $actividad; ?>"> Actividad: <?php echo $actividad; ?></h2>
    <?php
    
    // Mostrar tablas de alumnos inscritos por clase
    foreach ($clases as $clase => $alumnos) {
        ?>
        <table>
            <tr>
                <th><?php echo $clase; ?></th>
            </tr>
            <?php
            foreach ($alumnos as $alumno) {
                echo "<tr><td>$alumno</td></tr>";
            }
            ?>
        </table>
        <?php
    }
    
    ?>
    </main>
    <?php
}
?>
</form>
</body>
</html>