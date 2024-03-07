<?php
    require_once 'controlador.php';
    require_once 'php/model/msesion.php';
    /**
     * Clase donde están los métodos de inicio de sesión, registro y creación de la clase y alumnos al registrarse.
     */
    class Sesion extends Controlador{
        private $Sesion;
        function __construct(){
            $this->Sesion = new MSesion();
            $this->Modelo = new Modelo();
        }
        /**
         * Método que crea un nuevo usuario y genera una sesión.
         * Devuleve el formulario si los campos están vacío y si el usuario ya existe.
         */
        public function registroSesion(){
            $this->vista='vistaCrearClase';
            if(isset($_POST['nombreTutor'], $_POST['nombreUsuario'], $_POST['pswUsuario'])){
                $nombre=$_POST['nombreTutor'];
                $usuario=$_POST['nombreUsuario'];
                $psw=$_POST['pswUsuario'];

                if(!$this->Sesion->comprobar_usuario_tutor($usuario)){
                    $hash = password_hash($psw, PASSWORD_DEFAULT);
                    $id=$this->Sesion->registro($nombre,$usuario,$hash);
                    if ($id !== null) {
                        session_start();
                        $_SESSION['id']=$id;
                        $_SESSION['nombre']=$nombre;
                    } else {
                        $this->mensaje = "Error al registrar.";
                    }
                }
                else{
                    $this->mensaje = $usuario.' ya existe.';
                    $this->vista = 'vistaRegistro';
                }
            }
            else{
                $this->mensaje = 'Rellene todos los campos del formulario';
                $this->vista = 'vistaRegistro';
            }
        }
        /**
         * Método que muestra la vista del formulario de añadir alumnos desde la vista de añadir la clase.
         * Devuelve al formulario de la clase si encuentra campos vacíos o número de alunmos menor a 0.
         */
        public function vistaCrearAlumnos(){
            session_start();
            $this->vista = 'vistaCrearAlumnos';
            if(isset($_POST['nombreClase'],$_POST['nAlumnos'])){
                $clase = $_POST['nombreClase'];
                $nAlumnos = $_POST['nAlumnos'];
                if($nAlumnos>0){
                    $datos = array(
                        'clase' => $clase,
                        'nAlumnos' => $nAlumnos
                    );
                    return $datos;
                }
                else{
                    $this->mensaje = 'El número de alumnos no puede ser 0 o menos.';
                    $this->vista = 'vistaCrearClase';
                }
            }
            else{
                $this->mensaje = 'Rellene todos los campos';
                $this->vista = 'vistaCrearClase';
            }
        }

        public function vistaVolverClase(){
            session_start();
            $this->vista = 'vistaCrearClase';
            $datos = [
                "nombre" => $_GET['clase'],
                "nalumnos" => $_GET['n']
            ];
            return $datos; 

        }
        /**
         * Método que añade la clase y sus alumnos del tutor registrado.
         * Devuleve al formulario de añadir alumnos si 
         */
        public function generarClaseAlumnos(){
            session_start();
            $this->vista = 'vistaClase';
            $s = false;
            foreach ($_POST['alumnos'] as $i => $alumno) {
                if (empty($alumno['nombre'])) {
                    unset($_POST['alumnos'][$i]); // Elimina la fila del array donde el nombre del alumno está vacío
                } else {
                    $s = true;
                }
            }
            // Reindexa el array para evitar claves vacías después de la eliminación
            $_POST['alumnos'] = array_values($_POST['alumnos']);
            if($s){
                $alumnos = $_POST['alumnos'];
                $clase = $_POST['nombreClase'];
                $id = $_SESSION['id'];

                $s=$this->Sesion->aniadir_clase($id, $clase, $alumnos);
                if(!$s){
                    $this->mensaje = "Error al registrar.";
                    $this->vista = 'vistaCrearAlumnos';
                    $datos = array(
                        'clase' => $clase,
                        'nAlumnos' => $_POST['nAlumnos']
                    );
                    return $datos;
                }
                
                return $this->Modelo->tabla_alumno_inscripcion($id);
                
            }
            else{
                $this->mensaje = 'Rellene al menos un alumno';
                $this->vista = 'vistaCrearAlumnos';
                $datos = array(
                    'clase' => $_POST['nombreClase'],
                    'nAlumnos' => $_POST['nAlumnos']
                );
                return $datos;
            }
        }
        /**
         * Método que genera una sesión con los datos recibidos, puede crear una cookie para mantener la sesión abierta.
         * Si el usuario/contraseña es incorrecta, vuelve a mandar a la vista de inicio de sesión.
         */
        public function inicioSesion(){
            session_start();
            if($_POST['nombreUsuario'] && $_POST['pswUsuario']){
                $usuario = $_POST['nombreUsuario'];
                $psw = $_POST['pswUsuario'];

                $datos = $this->Sesion->inicio_sesion($usuario, $psw);
                if($datos){
                    $_SESSION['id']=$datos['id'];
                    $_SESSION['nombre']=$datos['nombre'];
                    if(isset($_POST['recuerdame'])){
                        $cookie=$_SESSION['id'].'/'.$_SESSION['nombre'];
                        setcookie('sesion', $cookie, time()+60*60*24*30, '/'); /* Dura 30 días */
                    }
                    $this->vista = 'vistaClase';
                    $alumnos = $this->Modelo->tabla_alumno_inscripcion($_SESSION['id']);
                    if(!empty($alumnos)){
                        return $alumnos;
                    }
                    else{
                        $this->vista = 'vistaCrearClase';
                    }
                }
                else{
                    $this->mensaje = 'Usuario o contraseña incorrectos.';
                    $this->vista = 'vistaSesion';
                }
            }
            else{
                $this->mensaje = 'Rellene todos los campos';
                $this->vista = 'vistaSesion';
            }
        }
        /**
         * Método que cierra la sesión abierta y manda a la vista de inicio de sesión.
         */
        public function cerrarSesion(){
            $this->vista = 'vistaSesion';
            session_start();
            session_unset();
            session_destroy();
            if(isset($_COOKIE['sesion'])){
                setcookie('sesion', '', time()-1, '/');
            }
            $this->mensaje = 'Se ha cerrado la sesión';
        }
    }