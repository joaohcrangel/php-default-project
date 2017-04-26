CREATE PROCEDURE sp_permissions_remove(
pidpermission INT
)
BEGIN

    DELETE FROM tb_permissions 
    WHERE idpermission = pidpermission;

END