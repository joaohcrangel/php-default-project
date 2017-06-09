CREATE PROCEDURE sp_projectslogs_remove(
pidlog INT
)
BEGIN

    DELETE FROM tb_projectslogs 
    WHERE idlog = pidlog;

END;