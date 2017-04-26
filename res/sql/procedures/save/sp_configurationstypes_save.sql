CREATE PROCEDURE sp_configurationstypes_save(
pidconfigurationtype INT,
pdesconfigurationtype VARCHAR(32)
)
BEGIN

    IF pidconfigurationtype = 0 THEN
    
        INSERT INTO tb_configurationstypes (desconfigurationtype)
        VALUES(pdesconfigurationtype);
        
        SET pidconfigurationtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_configurationstypes     
        SET 
            desconfigurationtype = pdesconfigurationtype        
        WHERE idconfigurationtype = pidconfigurationtype;

    END IF;

    CALL sp_configurationstypes_get(pidconfigurationtype);

END