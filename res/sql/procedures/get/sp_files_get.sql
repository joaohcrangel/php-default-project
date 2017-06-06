CREATE PROCEDURE sp_files_get(
pidfile INT
)
BEGIN

    SELECT a.*, b.despath FROM tb_files a
		LEFT JOIN tb_filespaths b ON a.idfile = b.idfile
    WHERE a.idfile = pidfile;

END