CREATE PROCEDURE sp_settings_save(
pidsetting INT,
pdessetting VARCHAR(64),
pdesvalue VARCHAR(2048),
pdesdescription VARCHAR(256),
pidsettingtype INT
)
BEGIN

    IF pidsetting = 0 THEN
    
        INSERT INTO tb_settings (dessetting, desvalue, idsettingtype, desdescription)
        VALUES(pdessetting, pdesvalue, pidsettingtype, pdesdescription);
        
        SET pidsetting = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_settings        
        SET 
            desconfiguracao = pdesconfiguracao,
            desvalue = pdesvalue,
            idsettingtype  = pidsettingtype ,
            desdescription = pdesdescription   
        WHERE idsetting  = pidsetting ;

    END IF;

    CALL sp_settings_get(pidsetting);

END