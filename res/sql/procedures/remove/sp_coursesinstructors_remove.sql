CREATE PROCEDURE sp_coursesinstructors_remove(
pidcourse INT,
pidinstructor INT
)
BEGIN

	DELETE FROM tb_coursesinstructors WHERE idcourse = pidcourse AND idinstructor = pidinstructor;

END