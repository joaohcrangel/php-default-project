CREATE PROCEDURE sp_permissionsmenus_save(
pidpermission INT,
pidmenu INT
)
BEGIN
    
    IF NOT EXISTS(SELECT * FROm tb_permissionsmenus WHERE idpermission = pidpermission AND idmenu = pidmenu) THEN
        INSERT INTO tb_permissionsmenus (idpermission, idmenu)
        VALUES(pidpermission, pidmenu);
    END IF;

    CALL sp_permissions_get(pidpermission);

END