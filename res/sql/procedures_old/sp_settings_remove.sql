CREATE PROCEDURE sp_settings_remove(
pidsetting INT
)
BEGIN

    DELETE FROM tb_settings 
    WHERE idsetting = pidsetting;

END