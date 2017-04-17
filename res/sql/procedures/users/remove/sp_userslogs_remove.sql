CREATE PROCEDURE sp_userslogs_remove(
pidlog INT
)
BEGIN

    DELETE FROM tb_userslogs 
    WHERE idlog = pidlog;

END