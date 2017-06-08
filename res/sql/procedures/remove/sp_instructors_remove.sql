CREATE PROCEDURE sp_instructors_remove(
pidinstructor INT
)
BEGIN

    DELETE FROM tb_instructors 
    WHERE idinstructor = pidinstructor;

END;