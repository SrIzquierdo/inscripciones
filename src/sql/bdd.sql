CREATE TABLE tutor(
    `id` tinyint UNSIGNED AUTO_INCREMENT NOT NULL,
    `usuario` varchar(20)  NOT NULL,
    `psw` char(60) NULL,
    `nombre` varchar(50)  NOT NULL,
    CONSTRAINT pkTutor PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE clase(
    `id` tinyint UNSIGNED AUTO_INCREMENT NOT NULL,
    `nombre` varchar(15) NOT NULL,
    `id_tutor` tinyint UNSIGNED NOT NULL,
    `imagen` char(5) NULL,
    CONSTRAINT pkClase PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE alumno(
    `id` int UNSIGNED AUTO_INCREMENT NOT NULL,
    `nombre` varchar(50)  NOT NULL,
    `genero` char(1) NOT NULL, /* m=Masculino y f=Femenino */
    `id_clase` tinyint UNSIGNED NOT NULL,
    CONSTRAINT pkAlumno PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE actividad(
    `id` tinyint UNSIGNED AUTO_INCREMENT NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `genero` char(1) NOT NULL, /* m=Masculino, f=Femenino y x=Mixto */
    `nMaxAlumnos` tinyint UNSIGNED NOT NULL,
    CONSTRAINT pkActividad PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE inscripcion(
    `id_alumno` int UNSIGNED NOT NULL,
    `id_actividad` tinyint UNSIGNED NOT NULL,
    `fecha` date NOT NULL,
    CONSTRAINT pkInscripcion PRIMARY KEY (id_alumno, id_actividad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE UNIQUE INDEX tutor_clase ON clase(id_tutor);
CREATE UNIQUE INDEX usuario_tutor ON tutor(usuario);
CREATE UNIQUE INDEX nombre_clase ON clase(nombre);

ALTER TABLE clase
    ADD CONSTRAINT tutorClase FOREIGN KEY (id_tutor) REFERENCES tutor (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE alumno
    ADD CONSTRAINT claseAlumno FOREIGN KEY (id_clase) REFERENCES clase (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE inscripcion
    ADD CONSTRAINT alumnoInscripcion FOREIGN KEY (id_alumno) REFERENCES alumno (id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE inscripcion
    ADD CONSTRAINT actividadInscripcion FOREIGN KEY (id_actividad) REFERENCES actividad (id) ON DELETE CASCADE ON UPDATE CASCADE;
