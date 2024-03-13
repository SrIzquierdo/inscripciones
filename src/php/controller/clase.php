<?php
    require_once 'controlador.php';
    require_once 'php/model/mclase.php';
    /**
     * Clase donde están los métodos de creación de la clase y alumnos.
     */
    class Clase extends Controlador{
        private $Clase;
        function __construct(){
            $this->Clase = new MClase();
            $this->Modelo = new Modelo();
        }
        /**
         * Método que añade la clase y sus alumnos del tutor registrado.
         * Devuleve al formulario de añadir alumnos si 
         */
        public function generarClaseAlumnos(){
            session_start();
            $this->vista = 'vistaClase';
            $s = false;
            if(isset($_FILES['imagenClase']) AND $_FILES['imagenClase']['error'] === UPLOAD_ERR_OK){
                // Obtener la extensión del archivo
                $extension = pathinfo($_FILES['imagenClase']['name'], PATHINFO_EXTENSION);

                // Verificar si la extensión es válida
                $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
                if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                    $this->mensaje = 'Extensión no permitida, solo imagenes';
                    $this->vista = 'vistaCrearAlumnos';
                    $datos = array(
                        'clase' => $_POST['nombreClase'],
                        'nAlumnos' => $_POST['nAlumnos']
                    );
                    return $datos;
                }
            }
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
                //Tratado de la imagen.
                $extension = false;
                if(isset($_FILES['imagenClase'])){
                    $ruta = "classes/";
                    $nombreImagen = $clase."Imagen.jpg";
                    $extension = pathinfo($_FILES['imagenClase']['name'], PATHINFO_EXTENSION);
                    if(!move_uploaded_file(($_FILES['imagenClase']['tmp_name']),$ruta.$nombreImagen)) {
                        $this->mensaje = 'La imagen no se ha podido guardar, pruebe con otra imagen';
                        $this->vista = 'vistaCrearAlumnos';
                        $datos = array(
                            'clase' => $_POST['nombreClase'],
                            'nAlumnos' => $_POST['nAlumnos']
                        );
                        return $datos;
                    }
                }
                $s=$this->Clase->aniadir_clase($id, $clase, $alumnos, $extension);
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
        /** */
        public function vistaDatosClase(){
            session_start();
            $this->vista = 'vistaDatosClase';
            if(isset($_SESSION['id'])){
                $datos = $this->Clase->datos_clase($_SESSION['id']);
                return $datos;
            }
            else{
                $this->vistaSesion();
            }
        }
        /** */
        public function modificarImagenClase(){
            session_start();
            $this->vista = 'vistaDatosClase';
            if(isset($_SESSION['id'])){
                $imagenExistente = "classes/".$_POST['nombreClase']."Imagen.jpg";
                if(isset($_FILES['imagenClase']) AND $_FILES['imagenClase']['error'] === UPLOAD_ERR_OK){
                    $extension = false;
                    if(isset($_FILES['imagenClase']) AND $_FILES['imagenClase']['error'] === UPLOAD_ERR_OK){
                        // Obtener la extensión del archivo
                        $extension = pathinfo($_FILES['imagenClase']['name'], PATHINFO_EXTENSION);
        
                        // Verificar si la extensión es válida
                        $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif');
                        if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                            $this->mensaje = 'Extensión no permitida, solo imagenes.';
                            $datos = $this->Clase->datos_clase($_SESSION['id']);
                            return $datos;
                        }
                    }
                    if(file_exists($imagenExistente)){
                        if(unlink($imagenExistente) AND move_uploaded_file(($_FILES['imagenClase']['tmp_name']),$imagenExistente)){
                            $this->mensaje = 'La imagen ha sido modificada.';
                        }
                        else{
                            $this->mensaje = 'La imagen no se pudo modificar.';
                        }
                    }
                    else{
                        if(move_uploaded_file(($_FILES['imagenClase']['tmp_name']),$imagenExistente)){
                            if($this->Clase->modificar_imagen($_POST['nombreClase'])){
                                $this->mensaje = 'La imagen fue añadida.';
                            }
                            else{
                                $this->mensaje = 'La imagen no se pudo añadir.';
                            }
                        }
                        else{
                            $this->mensaje = 'La imagen no se pudo añadir.';
                        }
                    }
                }
                else{
                    $this->mensaje = 'Seleccione una imagen para ';
                    if(file_exists($imagenExistente)){$this->mensaje .= 'modificar.';}
                    else{$this->mensaje .= 'añadir.';}
                }
                $datos = $this->Clase->datos_clase($_SESSION['id']);
                return $datos;
            }
            else{
                $this->vistaSesion();
            }
        }

        public function eliminarImagen(){
            session_start();
            $this->vista = 'vistaDatosClase';
            $imagenExistente = "classes/".$_GET['clase']."Imagen.jpg";
            if(unlink($imagenExistente)){
                if($this->Clase->eliminar_imagen($_GET['clase'])){
                    $this->mensaje = 'La imagen se ha eliminado';
                }
                else{
                    $this->mensaje = 'La imagen no se pudo eliminar';
                }
            }
            else{
                $this->mensaje = 'La imagen no se pudo eliminar';
            }
            $datos = $this->Clase->datos_clase($_SESSION['id']);
            return $datos;
        }
    }