CREATE PROCEDURE sp_configurations_get(
pidconfiguration INT
)
BEGIN

    SELECT *    
    FROM tb_configurations    
    WHERE idconfiguration = pidconfiguration;

END