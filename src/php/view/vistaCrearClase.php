<main class="sesion">
            <h1>¿Cuál es tu clase?</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Sesion&metodo=vistaCrearAlumnos" method="post">
                <p>
                <label for="nombreClase">Nombre</label>
                    <input type="text" id="nombreClase" name="nombreClase">
                </p>
                <p>
                    <label for="nAlumnos">Número de alumnos</label>
                    <input type="number" name="nAlumnos" id="nAlumnos">
                </p>
                <input type="submit" value="Enviar">
            </form>
        </main>
    </body>
</html>