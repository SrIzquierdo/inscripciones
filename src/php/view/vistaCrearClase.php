<main class="sesion">
            <h1>¿Cuál es tu clase?</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?metodo=vistaCrearAlumnos" method="post">
                <p>
                <label for="nombreClase">Nombre</label>
                    <input type="text" id="nombreClase" name="nombreClase"
                    <?php 
                        if(isset($datos['nombre'])){
                            echo 'value="'.$datos['nombre'].'"';
                        }
                    ?>>
                </p>
                <p>
                    <label for="nAlumnos">Número de alumnos</label>
                    <input type="number" name="nAlumnos" id="nAlumnos"
                    <?php 
                        if(isset($datos['nalumnos'])){
                            echo 'value="'.$datos['nalumnos'].'"';
                        }
                    ?>>
                </p>
                <input type="submit" value="Enviar">
            </form>
        </main>
    </body>
</html>