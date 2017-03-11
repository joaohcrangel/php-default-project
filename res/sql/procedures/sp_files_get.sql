CREATE PROCEDURE sp_files_get(
pidfile INT
)
BEGIN

    SELECT *    
    FROM tb_files    
    WHERE idfile = pidfile;

END