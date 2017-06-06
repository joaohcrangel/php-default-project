CREATE PROCEDURE sp_filestrigger_save(
pidfile INT
)
BEGIN

	DECLARE pdespath VARCHAR(256);

	SELECT CONCAT(a.desdirectory, a.desfile, '.', a.desextension) AS despath INTO pdespath FROM tb_files a
	WHERE a.idfile = pidfile;

	SET @disabled_triggers = 1;

	UPDATE tb_files SET
		despath = pdespath
	WHERE idfile = pidfile;

	SET @disabled_triggers = 0;

END