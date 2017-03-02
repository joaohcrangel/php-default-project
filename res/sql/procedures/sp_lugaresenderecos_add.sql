CREATE PROCEDURE sp_lugaresenderecos_add(
pidlugar INT,
pidendereco INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_lugaresenderecos WHERE idlugar = pidlugar AND idendereco = pidendereco) THEN
    
		INSERT INTO tb_lugaresenderecos(idlugar, idendereco)
        VALUES(pidlugar, pidendereco);
        
	END IF;

END