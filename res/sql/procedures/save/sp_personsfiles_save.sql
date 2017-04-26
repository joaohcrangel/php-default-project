CREATE PROCEDURE sp_personsfiles_save (
pidperson INT,
pidfile INT
)
BEGIN

	DELETE FROM tb_personsfiles WHERE idperson = pidperson AND idfile = pidfile;
    INSERT INTO tb_personsfiles (idperson, idfile)
    VALUES(pidperson, pidfile);

END
