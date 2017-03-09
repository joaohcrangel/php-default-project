CREATE PROCEDURE sp_placees_remove(
pidplace INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_placeescoordinates WHERE idplace = pidplace) THEN
    
		DELETE FROM tb_placeescoordinates WHERE idplace = pidplace;
        
	END IF;
    
    IF EXISTS(SELECT * FROM tb_placeesschedules WHERE idplace = pidplace) THEN
    
		DELETE FROM tb_placeesschedules WHERE idplace = pidplace;
        
	END IF;

	DELETE FROM tb_placees WHERE idplace = pidplace;

END