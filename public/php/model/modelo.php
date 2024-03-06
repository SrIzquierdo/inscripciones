<?php
    require_once 'conexion.php';
    class Modelo extends Conexion{
        public function tabla_inscripciones(){
            $sql = "SELECT alumno.nombre AS alumno, clase.nombre AS clase, actividad.nombre AS actividad
                    FROM alumno
                    JOIN clase ON alumno.id_clase = clase.id
                    LEFT JOIN inscripcion ON inscripcion.id_alumno = alumno.id
                    LEFT JOIN actividad ON inscripcion.id_actividad = actividad.id
                    ORDER BY actividad, clase";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
        
            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                $actividad = $fila['actividad'];
                $clase = $fila['clase'];
                $alumno = $fila['alumno'];
        
                // Agrupar los datos por actividad y luego por clase dentro de cada actividad
                if (!isset($datos[$actividad])) {
                    $datos[$actividad] = array();
                }
        
                if (!isset($datos[$actividad][$clase])) {
                    $datos[$actividad][$clase] = array();
                }
        
                $datos[$actividad][$clase][] = $alumno;
            }
        
            return $datos;
        }
        /**
         * Devuelve los datos de todas las atividades
         */
        public function tabla_actividad(){
            $sql = "SELECT nombre
                FROM actividad
                INNER JOIN inscripcion ON actividad.id = inscripcion.id_actividad
                GROUP BY actividad.id;";
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
    }