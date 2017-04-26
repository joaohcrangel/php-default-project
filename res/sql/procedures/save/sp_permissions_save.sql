CREATE PROCEDURE sp_permissions_save(
pidpermission INT,
pdespermission VARCHAR(64)
)
BEGIN

    IF pidpermission = 0 THEN
    
        INSERT INTO tb_permissions (despermission)
        VALUES(pdespermission);
        
        SET pidpermission = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_permissions        
        SET 
            despermission = pdespermission
        WHERE idpermission = pidpermission;

    END IF;

    CALL sp_permissions_get(pidpermission);

END