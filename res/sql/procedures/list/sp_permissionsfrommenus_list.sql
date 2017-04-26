CREATE PROCEDURE sp_permissionsfrommenus_list(
pidmenu INT
)
BEGIN
    
    SELECT *
    FROM tb_permissions a
    INNER JOIN tb_permissionsmenus b ON a.idpermission = b.idpermission
    WHERE b.idmenu = pidmenu
    ORDER BY a.despermission;
    
END