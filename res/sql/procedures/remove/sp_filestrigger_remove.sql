CREATE PROCEDURE sp_filestrigger_remove(
pidfile INT
)
BEGIN

	DELETE FROM tb_filespaths WHERE idfile = pidfile;

END