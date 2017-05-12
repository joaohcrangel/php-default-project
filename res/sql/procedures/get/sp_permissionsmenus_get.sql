CREATE PROCEDURE sp_permissionsmenus_get(
pidpermission INT
)
BEGIN

    SELECT *    
    FROM tb_permissionsmenus    
    WHERE idpermission = pidpermission;

END;