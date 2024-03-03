<?php
    require 'php/config/configDB.php';
    require_once 'conexion.php';
    class Modelo extends Conexion{
        /**
         * Devuelve los datos de todas las atividades
         */
        public function tabla_actividad(){
            $sql = "SELECT * FROM actividad";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();

            return $datos;
        }
        /**
         * Método que devuleve el número de alumnos inscritos por actividad de un tutor en específico.
         */
        public function numero_alumnos_inscritos_por_actividad($tutor){
            $sql="SELECT COUNT(inscripcion.id_alumno) AS numero_alumnos_inscritos, inscripcion.id_actividad AS actividad
            FROM inscripcion
            JOIN alumno ON inscripcion.id_alumno = alumno.id
            JOIN clase ON alumno.id_clase = clase.id
            JOIN tutor ON clase.id_tutor = tutor.id
            WHERE tutor.id = ?
            GROUP BY inscripcion.id_actividad;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $tutor);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuleve los datos de los alumnos inscritos en alguna actividad
         */
        public function tabla_alumno_inscripcion($tutor){
            $sql = "SELECT alumno.nombre AS alumno, clase.nombre AS clase, actividad.nombre AS actividad
                FROM alumno
                JOIN clase ON alumno.id_clase = clase.id
                LEFT JOIN inscripcion ON inscripcion.id_alumno = alumno.id
                LEFT JOIN actividad ON inscripcion.id_actividad = actividad.id
                JOIN tutor ON clase.id_tutor = tutor.id
                WHERE tutor.id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $tutor);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuelve los datos de la actividad, los alumnos que se pueden inscribir y los alumnos inscritos
        */
        public function select_alumnos_inscripcion($actividad, $tutor){
            $sqlActividad = "SELECT * FROM actividad WHERE id = ?";

            $stmtActividad = $this->conexion->prepare($sqlActividad);
            $stmtActividad->bind_param('i', $actividad);
            $stmtActividad->execute();

            $resulActividad = $stmtActividad->get_result();
            $stmtActividad->close();

            $datosActividad = $resulActividad->fetch_assoc();
            $genero = $datosActividad['genero'];

            $datos = [
                "id" => $datosActividad['id'],
                "actividad" => $datosActividad['nombre'],
                "max_alumnos" => $datosActividad['nMaxAlumnos'],
                "alumnos" => $this->datos_alumnos_por_genero($genero, $tutor),
                "alumnos_inscritos" => $this->datos_alumnos_inscritos_por_clase($actividad, $tutor)
            ];
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuleve los alumnos de una clase por el genero de la actividad o por del propio genero del alumno.
         */
        public function datos_alumnos_por_genero($genero, $tutor){
            $stmtAlumno = null;
            $sqlAlumno = "SELECT alumno.id AS id, alumno.nombre AS nombre
                FROM alumno
                JOIN clase ON alumno.id_clase = clase.id
                JOIN tutor ON clase.id_tutor = tutor.id
                WHERE tutor.id = ?";
            if($genero =='x'){
                $stmtAlumno = $this->conexion->prepare($sqlAlumno);
                $stmtAlumno->bind_param('i', $tutor);
            }
            else{
                $sqlAlumno .= " AND alumno.genero = ?";
                $stmtAlumno = $this->conexion->prepare($sqlAlumno);
                $stmtAlumno->bind_param('is', $tutor, $genero);
            }
            $stmtAlumno->execute();

            $resulAlumno = $stmtAlumno->get_result();
            $stmtAlumno->close();
            
            $alumnos = array();
            while ($fila = $resulAlumno->fetch_assoc()) {
                array_push($alumnos, $fila);
            }
            return $alumnos;
        }
        /**
         * Devuleve los alumnos inscritos en una actividad en una clase
         */
        public function datos_alumnos_inscritos_por_clase($actividad, $tutor){
            $sql = "SELECT id_alumno FROM inscripcion
            JOIN alumno ON id_alumno = alumno.id
            JOIN clase ON id_clase = clase.id
            JOIN tutor ON id_tutor = tutor.id
            WHERE id_actividad = ? AND tutor.id=?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $actividad,$tutor);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();

            $alumnos_inscritos = array();
            while ($fila = $resul->fetch_assoc()) {
                array_push($alumnos_inscritos, $fila);
            }
            return $alumnos_inscritos;
        }
        /**
         * Elimina el alumno inscrito en una actividad.
         */
        public function eliminar_inscrito($alumno, $actividad){
            $sql = "DELETE FROM inscripcion WHERE id_alumno = ? AND id_actividad = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $alumno, $actividad);
            $stmt->execute();
        }

        /**
         * Guarda en la base de datos la id del alumno, la actividad y la fecha al inscribir.
         */
        public function inscribir_alumno($alumno, $actividad){
            $fecha = new DateTime();
            $fechaFormateada = $fecha->format('Y-m-d');
            $sql = "INSERT INTO inscripcion (id_alumno, id_actividad, fecha) VALUES(?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('iis', $alumno, $actividad, $fechaFormateada);
            $stmt->execute();
        }   
    }