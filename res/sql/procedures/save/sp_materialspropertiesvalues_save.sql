CREATE PROCEDURE sp_materialspropertiesvalues_save(
pidmaterial INT,
pidproperty INT,
pdesvalue VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidmaterial = 0 THEN
    
        INSERT INTO tb_materialspropertiesvalues (desvalue, dtregister)
        VALUES(pdesvalue, pdtregister);
        
        SET pidmaterial = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_materialspropertiesvalues        
        SET 
            desvalue = pdesvalue,
            dtregister = pdtregister        
        WHERE idmaterial = pidmaterial;

    END IF;

    CALL sp_materialspropertiesvalues_get(pidmaterial);

END;