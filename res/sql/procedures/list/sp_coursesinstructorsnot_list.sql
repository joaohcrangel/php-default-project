CREATE PROCEDURE sp_coursesinstructorsnot_list(
pidcourse INT
)
BEGIN

	SELECT a.*, b.desperson FROM tb_instructors a
		INNER JOIN tb_persons b ON a.idperson = b.idperson    
    WHERE a.idinstructor NOT IN(
		SELECT idinstructor FROM tb_coursesinstructors WHERE idcourse = pidcourse
	);

END