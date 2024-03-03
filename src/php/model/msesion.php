<?php
    require_once 'conexion.php';
    class MSesion extends Conexion{
        /**
         * Función que devuleve los datos del tutor o false si no devuelve ninguna fila.
         */
        public function inicio_sesion($usuario, $psw){
            $sql = "SELECT id, nombre, psw FROM tutor
            WHERE usuario = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $usuario);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            if($resul->num_rows > 0){
                $datos = $resul->fetch_assoc();
                if(password_verify($psw,$datos['psw'])){
                    unset($datos['psw']);
                    return $datos;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        /**
         * Método que comprueba si el nombre de usuario existe al registrarse el tutor
         */
        public function comprobar_usuario_tutor($usuario){
            $sql = "SELECT usuario FROM tutor WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $usuario);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            if($resul->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }
        /**
         * Método para registrar al tutor
         */
        public function registro($nombre,$usuario,$hash){
            $sql = "INSERT INTO tutor (nombre, usuario, psw) VALUES(?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sss', $nombre,$usuario,$hash);
            if ($stmt->execute()) {
                return $this->conexion->insert_id;
            } else {
                return null;
            }
        }
        /**
         * Método de añadir la clase del tutor. Este método solo se realiza después del registro del tutor.
         */
        public function aniadir_clase($id, $clase, $alumnos){
            $sql = "INSERT INTO clase (nombre, id_tutor) VALUES (?,?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('si', $clase, $id);
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
         * Método de añadir los alumnos del tutor. Este método solo se realiza después del registro del tutor.
         */
        public function aniadir_alumno($id, $alumnos){
            $sql = "INSERT INTO alumno (nombre, genero, id_clase) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ssi', $nombre, $genero, $id);
            foreach($alumnos as $alumno){
                $nombre = $alumno['nombre'];
                $genero = $alumno['genero'];
                if(!$stmt->execute()){
                    return null;
                }
            }
            return true;
        }
    }