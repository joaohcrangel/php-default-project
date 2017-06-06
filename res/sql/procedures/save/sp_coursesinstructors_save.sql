CREATE PROCEDURE sp_coursesinstructors_save(
pidcourse INT,
pidinstructor INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_coursesinstructors WHERE idcourse = pidcourse AND idinstructor = pidinstructor) THEN

		INSERT INTO tb_coursesinstructors(idcourse, idinstructor) VALUES(pidcourse, pidinstructor);

	END IF;

END