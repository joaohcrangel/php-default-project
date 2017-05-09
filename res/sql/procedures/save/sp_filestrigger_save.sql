CREATE PROCEDURE sp_filestrigger_save(
pidfile INT
)
BEGIN

	DECLARE pdespath VARCHAR(256);

	SELECT INTO pdespath CONCAT(a.desdirectory, a.desfile, '.', a.desextension) AS despath FROM tb_files a
	WHERE a.idfile = pidfile;

	UPDATE tb_files SET
		despath = pdespath
	WHERE idfile = pidfile;
	

END