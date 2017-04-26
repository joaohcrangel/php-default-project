CREATE PROCEDURE sp_configurations_save(
pidconfiguration INT,
pdesconfiguration VARCHAR(64),
pdesvalue VARCHAR(2048),
pdesdescription VARCHAR(256),
pidconfigurationtype INT
)
BEGIN

    IF pidconfiguration = 0 THEN
    
        INSERT INTO tb_configurations (desconfiguration, desvalue, idconfigurationtype, desdescription)
        VALUES(pdesconfiguration, pdesvalue, pidconfigurationtype, pdesdescription);
        
        SET pidconfiguration = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_configurations
        SET 
            desconfiguration = pdesconfiguration,
            desvalue = pdesvalue,
            idconfigurationtype  = pidconfigurationtype,
            desdescription = pdesdescription   
        WHERE idconfiguration  = pidconfiguration ;

    END IF;

    CALL sp_configurations_get(pidconfiguration);

END