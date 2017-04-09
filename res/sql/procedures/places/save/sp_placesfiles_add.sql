CREATE PROCEDURE sp_placesfiles_add(
pidplace INT,
pidfile INT
)
BEGIN

	IF NOT EXISTS(SELECT * FROM tb_placesfiles WHERE idplace = pidplace AND idfile = pidfile) THEN
    
		INSERT INTO tb_placesfiles(idplace, idfile)
        VALUES(pidplace, pidfile);
        
	END IF;

END