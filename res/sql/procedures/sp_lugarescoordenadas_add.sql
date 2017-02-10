CREATE PROCEDURE sp_lugarescoordenadas_add(
pidlugar INT,
pidcoordenada INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_lugarescoordenadas WHERE idlugar = pidlugar AND idcoordenada = pidcoordenada) THEN
    
		INSERT INTO tb_lugarescoordenadas(idlugar, idcoordenada) VALUES(pidlugar, pidcoordenada);
        
	END IF;

END