INSERT INTO tutor (usuario, nombre) VALUES('TutorESO','Tutor de ESO');
INSERT INTO tutor (usuario, nombre) VALUES('TutorBACH','Tutor de Bachillerato');

INSERT INTO clase (nombre, id_tutor) VALUES('ESO',1);
INSERT INTO clase (nombre, id_tutor) VALUES('BACH',2);

INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 1 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 2 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 3 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 4 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 5 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 6 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 7 ESO', 'm', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 8 ESO', 'm', 1);

INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 1 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 2 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 3 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 4 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 5 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 6 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 7 ESO', 'f', 1);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 8 ESO', 'f', 1);

INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 1 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 2 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 3 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 4 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 5 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 6 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 7 BACH', 'm', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chico 8 BACH', 'm', 2);

INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 1 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 2 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 3 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 4 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 5 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 6 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 7 BACH', 'f', 2);
INSERT INTO alumno (nombre, genero, id_clase) VALUES('Chica 8 BACH', 'f', 2);

INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Carrera 200m Masculino', 'm', 3);
INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Carrera 200m Femenino', 'f', 3);
INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Carrera 400m Masculino', 'm', 1);
INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Carrera 400m Femenino', 'f', 1);
INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Fútbol', 'x', 8);
INSERT INTO actividad (nombre, genero, nMaxAlumnos) VALUES('Cuatrola', 'x', 4);