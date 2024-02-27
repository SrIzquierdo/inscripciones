/* Sacar alumnos de una clase con la id del tutor */
SELECT alumno.id AS id, alumno.nombre AS nombre FROM alumno
    JOIN clase ON alumno.id_clase = clase.id
    JOIN tutor ON clase.id_tutor = tutor.id
WHERE tutor.id = ?;

/* Sacar los alumnos inscritos con su actividad y su clase, si el alumno no tiene actividad saldrá NULL */
SELECT alumno.nombre AS alumno, clase.nombre AS clase, actividad.nombre AS actividad
FROM alumno
    JOIN clase ON alumno.id_clase = clase.id
    LEFT JOIN inscripcion ON inscripcion.id_alumno = alumno.id
    LEFT JOIN actividad ON inscripcion.id_actividad = actividad.id
    JOIN tutor ON clase.id_tutor = tutor.id
WHERE tutor.id = ?;

/* Sacar todos los alumnos inscritos con su actividad y su clase, si el alumno no tiene actividad saldrá NULL */
SELECT alumno.nombre AS alumno, clase.nombre AS clase, actividad.nombre AS actividad
FROM alumno
    JOIN clase ON alumno.id_clase = clase.id
    LEFT JOIN inscripcion ON inscripcion.id_alumno = alumno.id
    LEFT JOIN actividad ON inscripcion.id_actividad = actividad.id

/* Acar todos los datos de las actividades */
SELECT * FROM actividad

/* Sacar la id y nombre del alumno de una clase dependiendo del genero */
SELECT alumno.id AS id_alumno, alumno.nombre AS alumno
FROM alumno
    JOIN clase ON alumno.id_clase = clase.id
    JOIN tutor ON clase.id_tutor = tutor.id
WHERE alumno.genero = ? AND tutor.id = ?;

/* Sacar la id y nombre de un tutor con inicio de sesión */
SELECT id, nombre FROM tutor
WHERE usuario = ? AND psw =?


/* Sacar el id de los alumnos inscritos en una actividad */
SELECT id_alumno FROM inscripcion
    JOIN alumno ON id_alumno = alumno.id
    JOIN clase ON id_clase = clase.id
    JOIN tutor ON id_tutor = tutor.id
WHERE id_actividad = ? AND tutor.id=?;

/* Eliminar la inscripción de un alumno en una actividad */
DELETE FROM inscripcion WHERE id_alumno = ? AND id_actividad = ?;

/* Insertar alumno con su actividad */
INSERT INTO inscripcion (id_alumno, id_actividad, fecha) VALUES(?,?,?);