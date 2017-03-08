CREATE PROCEDURE sp_orderslogs_get(
pidlog INT
)
BEGIN

    SELECT *    
    FROM tb_orderslogs    
    WHERE idlog = pidlos;

END