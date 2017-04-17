CREATE PROCEDURE sp_placesaddresses_add(
pidplace INT,
pidaddress INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placesaddresses WHERE idplace = pidplace AND idaddress = pidaddress) THEN
    
		INSERT INTO tb_placesaddresses(idplace, idaddress)
        VALUES(pidplace, pidaddress);
        
	END IF;

END