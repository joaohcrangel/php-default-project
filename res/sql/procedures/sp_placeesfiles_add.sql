CREATE PROCEDURE sp_placeesfiles_add(
pidplace INT,
pidfile INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placeesfiles WHERE idplace = pidplace AND idfile = pidfile) THEN
    
		INSERT INTO tb_placeesfiles(idplace, ididplace)
        VALUES(pidplace, pidfile);
        
	END IF;

END