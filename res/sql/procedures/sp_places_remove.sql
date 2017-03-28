CREATE PROCEDURE sp_places_remove(
pidplace INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_placescoordinates WHERE idplace = pidplace) THEN
    
		DELETE FROM tb_placescoordinates WHERE idplace = pidplace;
        
	END IF;
    
    IF EXISTS(SELECT * FROM tb_placesschedules WHERE idplace = pidplace) THEN
    
		DELETE FROM tb_placesschedules WHERE idplace = pidplace;
        
	END IF;

	IF EXISTS(SELECT * FROM tb_placesaddresses WHERE idplace = pidplace) THEN

		DELETE FROM tb_placesaddresses WHERE idplace = pidplace;

	END IF;

	DELETE FROM tb_places WHERE idplace = pidplace;

END