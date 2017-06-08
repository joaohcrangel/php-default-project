CREATE PROCEDURE sp_instructors_get(
pidinstructor INT
)
BEGIN

    SELECT *    
    FROM tb_instructors    
    WHERE idinstructor = pidinstructor;

END;