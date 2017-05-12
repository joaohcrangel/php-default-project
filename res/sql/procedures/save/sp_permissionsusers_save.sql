CREATE PROCEDURE sp_permissionsusers_save(
pidpermission INT,
piduser INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidpermission = 0 THEN
    
        INSERT INTO tb_permissionsusers (dtregister)
        VALUES(pdtregister);
        
        SET pidpermission = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_permissionsusers        
        SET 
            dtregister = pdtregister        
        WHERE idpermission = pidpermission;

    END IF;

    CALL sp_permissionsusers_get(pidpermission);

END;