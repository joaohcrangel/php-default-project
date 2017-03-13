CREATE PROCEDURE sp_configurations_list()
BEGIN

    SELECT *    
    FROM tb_configurations a
    INNER JOIN tb_configurationstypes b ON a.idconfigurationtype = b.idconfigurationtype;

END