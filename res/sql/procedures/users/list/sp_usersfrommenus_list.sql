CREATE PROCEDURE sp_usersfrommenus_list(
pidmenu INT
)
BEGIN

	SELECT * 
	FROM tb_users a
	INNER JOIN tb_permissionsusers b ON a.iduser = b.iduser
	INNER JOIN tb_permissionsmenus c ON c.idpermission = b.idpermission
	INNER JOIN tb_personsdata d ON d.idperson = a.idperson
	WHERE c.idmenu = pidmenu
	ORDER BY d.desperson;

END