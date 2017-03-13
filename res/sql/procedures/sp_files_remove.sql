CREATE PROCEDURE sp_files_remove(
pidfile INT
)
BEGIN

    DELETE FROM tb_files 
    WHERE idfile = pidfile;

END