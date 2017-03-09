CREATE PROCEDURE sp_placeescoordinates_add(
pidplace INT,
pidcoordinateINT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placeescoordinates WHERE idplace = pidplace AND idcoordinate = pidcoordinate) THEN
    
		INSERT INTO tb_placeescoordinates(idplace, idcoordinate) VALUES(pidplace, pidcoordinate);
        
	END IF;

END