CREATE PROCEDURE sp_instructorsfromcourse_list(
pidcourse INT
)
BEGIN

	SELECT a.*, b.desperson, CONCAT(d.desdirectory, d.desfile, '.', d.desextension) AS desphoto FROM tb_instructors a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
		INNER JOIN tb_coursesinstructors e ON a.idinstructor = e.idinstructor
		INNER JOIN tb_courses c ON e.idcourse = c.idcourse
		INNER JOIN tb_files d ON a.idphoto = d.idfile
	WHERE c.idcourse = pidcourse;

END