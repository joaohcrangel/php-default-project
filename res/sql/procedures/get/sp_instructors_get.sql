CREATE PROCEDURE sp_instructors_get(
pidinstructor INT
)
BEGIN

	SELECT a.idinstructor, a.idperson, a.idphoto, b.desperson, c.descourse, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_instructors a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
        LEFT JOIN tb_coursesinstructors e ON a.idinstructor = e.idinstructor
		LEFT JOIN tb_courses c ON e.idcourse = c.idcourse
		INNER JOIN tb_files d ON a.idphoto = d.idfile
	WHERE a.idinstructor = pidinstructor;

END
