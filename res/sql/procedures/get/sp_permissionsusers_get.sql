CREATE PROCEDURE sp_permissionsusers_get(
pidpermission INT
)
BEGIN

    SELECT *    
    FROM tb_permissionsusers    
    WHERE idpermission = pidpermission;

END;