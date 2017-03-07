CREATE PROCEDURE sp_permissionsmenus_remove(
pidpermission INT,
pidmenu INT
)
BEGIN

	DELETE FROM tb_permissionsmenus
    WHERE 
		idmenu = pidmenu
        AND
        idpermission = pidpermission;

END