CREATE PROCEDURE sp_userslogs_get(
pidlog INT
)
BEGIN

    SELECT *    
    FROM tb_userslogs    
    WHERE idlog = pidlog;

END