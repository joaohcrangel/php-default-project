CREATE PROCEDURE sp_orderslogs_remove(
pidlog INT
)
BEGIN

    DELETE FROM tb_orderslogs 
    WHERE idlog = pidlog;

END