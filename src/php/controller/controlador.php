<?php
    require_once 'php/config/config.php';
    require_once 'php/model/modelo.php';

    class Controlador{
        protected $Modelo;
        public $vista;
        public $mensaje;
        /**
         * Contructor de la clase Controlador, instancia un objeto de la clase Modelo.
         */
        function __construct(){
            $this->Modelo = new Modelo();
        }
        /**
         * Método por defecto, Comprueba que existe una cookie de recordar la sesión.
         */
        public function iniciarAplicacion(){
            $this->vista = 'vistaClase';
            session_start();
            session_unset();
            session_destroy();
            session_start();
            if(isset($_COOKIE['sesion'])){
                $_SESSION['id']=explode('/',$_COOKIE['sesion'])[0];
                $_SESSION['nombre']=explode('/',$_COOKIE['sesion'])[1];

                $alumnos = $this->Modelo->tabla_alumno_inscripcion($_SESSION['id']);
                if(!empty($alumnos)){
                    return $alumnos;
                }
                else{
                    $this->vista = 'vistaCrearClase';
                }
            }
            else{
                $this->vistaSesion();
                return null;
            }
        }
        /*
         * Método para ir a la vista para seleccionar la actividad. Si no hay sesión abierta, manda al usuario a iniciar sesión.
         */
        public function vistaActividades(){
            $this->vista = 'vistaActividades';
            session_start();
            if(isset($_SESSION['id'])){
                $datos = [
                    "actividad" => $this->Modelo->tabla_actividad(),
                    "alumnos" => $this->Modelo->numero_alumnos_inscritos_por_actividad($_SESSION['id'])
                ];
                return $datos;
            }
            else{
                $this->vistaSesion();
                return null;
            }
        }
        /**
         * Método para ir a la vista donde se muestran los alumnos inscritos de la clase de un tutor.
         * Si no hay sesión abierta, manda al usuario a iniciar sesión.
         */
        public function vistaClase(){
            $this->vista = 'vistaClase';
            session_start();
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];
                $alumnos = $this->Modelo->tabla_alumno_inscripcion($id);
                if(!empty($alumnos)){
                    return $alumnos;
                }
                else{
                    $this->vista = 'vistaCrearClase';
                }
            }
            else{
                $this->vistaSesion();
                return null;
            }
        }
        /**
         * Método para ir a la vista de inscribir a los alumnos a una actividad.
         * Si no hay sesión abierta, manda al usuario a iniciar sesión.
         */
        public function vistaInscribir(){
            $this->vista = 'vistaInscribir';
            session_start();
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];
                return $this->Modelo->select_alumnos_inscripcion($_GET['actividad'], $id);
            }
            else{
                $this->vistaSesion();
            }
        }
        /**
         * Método de la vista de iniciar sesión
         */
        public function vistaSesion(){
            $this->vista = 'vistaSesion';
        }
        /**
         * Método de la vista de registro
         */
        public function vistaRegistro(){
            $this->vista = 'vistaRegistro';
        }
        /**
         * Método que contiene toda la programación en el poceso de inscribir.
         * Compruba que los alumnos del formulario estén ya inscritos y que los alumnos inscritos vengan del formulario.
         */
        public function inscribir(){
            $this->vista = 'vistaClase';
            session_start();
            if(isset($_SESSION['id'])){
                $id = $_SESSION['id'];
                $alumnosSelect=array_unique($_POST['alumnos']); //Se obtiene un array sin duplicados
                $inscritosbd=$this->Modelo->datos_alumnos_inscritos_por_clase($_GET['actividad'],$id);
                $alumnosInscritos = array_column($inscritosbd, "id_alumno"); //Se obtiene un array de solo los campos con el índice escrito

                foreach($alumnosInscritos as $alumno){
                    $alumno.='';
                    if(!in_array($alumno, $alumnosSelect)){
                        $this->Modelo->eliminar_inscrito($alumno, $_GET['actividad']);
                    }
                }
                foreach($alumnosSelect as $alumno){
                    $alumno=(int)$alumno;
                    if($alumno>0){
                        if(!in_array($alumno, $alumnosInscritos)){
                            $this->Modelo->inscribir_alumno($alumno, $_GET['actividad']);
                        }
                    }
                }
                return $this->Modelo->tabla_alumno_inscripcion($id);
            }
            else{
                $this->vistaSesion();
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
        /**
         * Método que devuelve a la vista del formulario de la clase.
         */
        public function vistaVolverClase(){
            session_start();
            $this->vista = 'vistaCrearClase';
            $datos = [
                "nombre" => $_GET['clase'],
                "nalumnos" => $_GET['n']
            ];
            return $datos; 

        }
    }