CREATE PROCEDURE sp_filestrigger_save(
pidfile INT
)
BEGIN

	CALL sp_filestrigger_remove(pidfile);

	INSERT INTO tb_filespaths(
		idfile, despath
	)
	SELECT
		a.idfile, CONCAT(a.desdirectory, a.desfile, '.', a.desextension) AS despath FROM tb_files a
	WHERE a.idfile = pidfile;

END