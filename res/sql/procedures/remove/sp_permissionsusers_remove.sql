CREATE PROCEDURE sp_permissionsusers_remove(
pidpermission INT
)
BEGIN

    DELETE FROM tb_permissionsusers 
    WHERE idpermission = pidpermission;

END;