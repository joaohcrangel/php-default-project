CREATE PROCEDURE sp_configurationstypes_get(
pidconfigurationtype INT
)
BEGIN

    SELECT *    
    FROM tb_configurationstypes    
    WHERE idconfigurationtype = pidconfigurationtype;

END