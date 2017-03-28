CREATE PROCEDURE sp_files_remove(
pidfile INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_placesfiles WHERE idfile = pidfile) THEN

		DELETE FROM tb_placesfiles WHERE idfile = pidfile;

	END IF;

    DELETE FROM tb_files 
    WHERE idfile = pidfile;

END