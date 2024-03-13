<?php
    require_once 'conexion.php';
    class MClase extends Conexion{
        /**
         * Método de añadir la clase del tutor.
         */
        public function aniadir_clase($id, $clase, $alumnos, $extension){
            if($extension){
                $imagen = $clase.'Imagen.jpg';
                $sql = "INSERT INTO clase (nombre, id_tutor, imagen) VALUES (?,?,?)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('sis', $clase, $id, $imagen);
            }
            else{
                $sql = "INSERT INTO clase (nombre, id_tutor) VALUES (?,?)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param('si', $clase, $id);
            }
            if ($stmt->execute()) {
                $idClase = $this->conexion->insert_id;
                $s=$this->aniadir_alumno($idClase, $alumnos);
                if(!$s){
                    return null;
                }
                else{
                    return true;
                }
            }
            else {
                return null;
            }
        }
        /**
         * Método de añadir los alumnos del tutor.
         */
        public function aniadir_alumno($id, $alumnos){
            $sql = "INSERT INTO alumno (nombre, genero, id_clase) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssi', $nombre, $genero, $id);
            foreach($alumnos as $alumno){
                $nombre = $alumno['nombre'];
                $genero = $alumno['genero'];
                if(!$stmt->execute()){
                    return false;
                }
            }
            return true;
        }

        public function datos_clase($tutor){
            $sql = "SELECT * FROM clase WHERE id_tutor = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$tutor);
            $stmt->execute();
            $resul = $stmt->get_result();
            $stmt->close();

            $clase = array();
            while ($fila = $resul->fetch_assoc()) {
                $clase = $fila;
            }
            return $clase;
        }

        public function modificar_imagen($clase){
            $imagen = $clase.'Imagen.jpg';
            $sql="UPDATE clase SET imagen = ? WHERE nombre = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ss',$imagen, $clase);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function eliminar_imagen($clase){
            $sql="UPDATE clase SET imagen = NULL WHERE nombre = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $clase);
            if($stmt->execute()){
                return true;
            }
            else{
                return false;
            }
        }
    }