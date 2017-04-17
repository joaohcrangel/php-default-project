CREATE PROCEDURE sp_permissionsfrommenusmissing_list(
pidmenu INT
)
BEGIN
	
	SELECT *
	FROM tb_permissions a
	WHERE a.idpermission NOT IN(
		SELECT a1.idpermission
		FROM tb_permissions a1
		INNER JOIN tb_permissionsmenus b1 ON a1.idpermission = b1.idpermission
		WHERE b1.idmenu = pidmenu
	)
	ORDER BY a.despermission;
    
END