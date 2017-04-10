CREATE PROCEDURE sp_lugaresarquivos_add(
pidlugar INT,
pidarquivo INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_lugaresarquivos WHERE idlugar = pidlugar AND idarquivo = pidarquivo) THEN
    
		INSERT INTO tb_lugaresarquivos(idlugar, idarquivo)
        VALUES(pidlugar, pidarquivo);
        
	END IF;

END