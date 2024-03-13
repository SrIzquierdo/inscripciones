<?php
    require_once 'controlador.php';
    require_once 'php/model/msesion.php';
    /**
     * Clase donde están los métodos de inicio de sesión, registro.
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