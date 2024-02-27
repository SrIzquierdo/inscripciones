        <main class="sesion">
            <h1>Inicio de sesión</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Sesion&metodo=inicioSesion" method="post">
                <p>
                    <label for="nombreUsuario">Usuario</label>
                    <input type="text" id="nombreUsuario" name="nombreUsuario">
                </p>
                <p>
                    <label for="pswUsuario">Contraseña</label>
                    <input type="password" name="pswUsuario" id="pswUsuario">
                </p>
                <p>
                    <label for="recuerdame">¿Recordar sesión?</label>
                    <input type="checkbox" name="recuerdame" id="recuerdame">
                </p>
                <input type="submit" value="Enviar">
            </form>
        </main>
    </body>
</html>