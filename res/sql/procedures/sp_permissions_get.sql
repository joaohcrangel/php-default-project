CREATE PROCEDURE sp_permissions_get(
pidpermission INT
)
BEGIN

    SELECT *    
    FROM tb_permissions    
    WHERE idpermission = pidpermission;

END