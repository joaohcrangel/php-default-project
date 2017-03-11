CREATE PROCEDURE sp_settings_get(
pidsetting INT
)
BEGIN

    SELECT *    
    FROM tb_settings    
    WHERE idsetting = pidsetting;

END