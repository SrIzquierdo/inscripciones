<main class="sesion">
            <h1>Registrar cuenta</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Sesion&metodo=registroSesion" method="post">
                <p>
                <label for="nombreTutor">Nombre</label>
                    <input type="text" id="nombreTutor" name="nombreTutor">
                </p>
                <p>
                    <label for="nombreUsuario">Usuario</label>
                    <input type="text" id="nombreUsuario" name="nombreUsuario">
                </p>
                <p>
                    <label for="pswUsuario">Contraseña</label>
                    <input type="password" name="pswUsuario" id="pswUsuario">
                </p>
                <input type="submit" value="Enviar">
            </form>
        </main>
    </body>
</html>