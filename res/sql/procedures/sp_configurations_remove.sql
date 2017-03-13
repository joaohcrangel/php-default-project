CREATE PROCEDURE sp_configurations_remove(
pidconfiguration INT
)
BEGIN

    DELETE FROM tb_configurations 
    WHERE idconfiguration = pidconfiguration;

END