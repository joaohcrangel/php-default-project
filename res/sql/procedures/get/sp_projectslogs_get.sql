CREATE PROCEDURE sp_projectslogs_get(
pidlog INT
)
BEGIN

    SELECT *    
    FROM tb_projectslogs    
    WHERE idlog = pidlog;

END;