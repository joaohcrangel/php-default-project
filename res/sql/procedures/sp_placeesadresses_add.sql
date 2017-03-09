CREATE PROCEDURE sp_placeesadresses_add(
pidplace INT,
pidadress INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placeesadresses WHERE idplace = pidplace AND idadress = pidadress) THEN
    
		INSERT INTO tb_placeesadresses(idplace, idadress)
        VALUES(pidplace, pidadress);
        
	END IF;

END