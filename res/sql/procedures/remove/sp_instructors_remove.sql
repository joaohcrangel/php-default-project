CREATE PROCEDURE sp_instructors_remove(
pidinstructor INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_coursesinstructors WHERE idinstructor = pidinstructor) THEN
    
		DELETE FROM tb_coursesinstructors WHERE idinstructor = pidinstructor;
        
	END IF;

    DELETE FROM tb_instructors 
    WHERE idinstructor = pidinstructor;

END
