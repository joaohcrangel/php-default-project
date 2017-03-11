CREATE PROCEDURE sp_files_remove(
pidfileINT
)
BEGIN

    DELETE FROM tb_files 
    WHERE idfile = pidfile;

END