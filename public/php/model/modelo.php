<?php
    require_once 'conexion.php';
    class Modelo extends Conexion{
        public function tabla_inscripciones(){
            $sql = "SELECT alumno.nombre AS alumno, clase.nombre AS clase, actividad.nombre AS actividad
                FROM alumno
                JOIN clase ON alumno.id_clase = clase.id
                LEFT JOIN inscripcion ON inscripcion.id_alumno = alumno.id
                LEFT JOIN actividad ON inscripcion.id_actividad = actividad.id";
            $stmt = $this->conexion->prepare($sql);
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
    }