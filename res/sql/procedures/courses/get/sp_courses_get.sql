CREATE PROCEDURE sp_courses_get(
pidcourse INT
)
BEGIN

    SELECT *    
    FROM tb_courses    
    WHERE idcourse = pidcourse;

END