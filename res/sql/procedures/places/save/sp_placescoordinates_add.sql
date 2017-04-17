CREATE PROCEDURE sp_placescoordinates_add(
pidplace INT,
pidcoordinate INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placescoordinates WHERE idplace = pidplace AND idcoordinate = pidcoordinate) THEN
    
		INSERT INTO tb_placescoordinates(idplace, idcoordinate) VALUES(pidplace, pidcoordinate);
        
	END IF;

END