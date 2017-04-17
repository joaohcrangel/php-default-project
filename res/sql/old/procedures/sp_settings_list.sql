CREATE PROCEDURE sp_settings_list()
BEGIN

    SELECT *    
    FROM tb_settings a
    INNER JOIN tb_settingstypes b ON a.idsettingtype = b.idsettingtype;

END