CREATE PROCEDURE sp_configurationstypes_remove(
pidconfigurationtype INT
)
BEGIN

    DELETE FROM tb_configurationstypes 
    WHERE idconfigurationtype = pidconfigurationtype;

END