        <main class="contenedor">
            <h2><?php echo $datos['actividad'] ?></h2>
            <form action="?controlador=Controlador&metodo=inscribir&actividad=<?php echo $datos['id']; ?>" method="post">
            <?php
                for ($i = 0; $i < $datos['max_alumnos']; $i++) {
                    ?>
                    <p><select name="alumnos[<?php echo $i; ?>]">
                        <option value="0">- Ninguno -</option>
                        <?php
                        foreach ($datos['alumnos'] as $fila) {
                            ?>
                            <option value="<?php echo $fila['id']; ?>"
                                <?php
                                if (isset($datos['alumnos_inscritos'][$i]) && in_array($fila['id'], $datos['alumnos_inscritos'][$i])) {
                                    echo "selected";
                                }
                                ?>
                            ><?php echo $fila['nombre']; ?></option>
                            <?php
                        }
                        ?>
                    </select></p>
                    <?php
                }
            ?>
                <input type="submit" value="Enviar">
                <a href="?controlador=Controlador&metodo=vistaActividades" class="boton">Volver</a>
            </form>
        </main>
    </body>
</html>