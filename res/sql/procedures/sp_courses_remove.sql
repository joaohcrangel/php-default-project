CREATE PROCEDURE sp_courses_remove(
pidcourse INT
)
BEGIN

    DELETE FROM tb_courses 
    WHERE idcourse = pidcourse;

END