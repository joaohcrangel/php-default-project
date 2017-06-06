CREATE PROCEDURE sp_files_get(
pidfile INT
)
BEGIN

    SELECT *, CONCAT(desdirectory, desfile, '.', desextension)
    FROM tb_files    
    WHERE idfile = pidfile;

END