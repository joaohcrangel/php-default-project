CREATE PROCEDURE sp_menusfromuser_list(
piduser INT
)
BEGIN
	
    SELECT
	CASE WHEN a.idmenufather IS NULL THEN 0 ELSE a.idmenufather END idmenufather, a.idmenu, a.desmenu, a.desicon, a.deshref, a.nrorder, a.dtregister, a.nrsubmenus,
	CASE WHEN b.desmenu IS NULL THEN 'Root' ELSE b.desmenu END AS desmenufather
	FROM tb_menus a
	LEFT JOIN tb_menus b ON b.idmenu = a.idmenufather
	INNER JOIN tb_permissionsmenus c ON c.idmenu = a.idmenu
	INNER JOIN tb_permissionsusers d ON d.idpermission = c.idpermission
	WHERE
		d.iduser = piduser
	GROUP BY a.idmenufather, a.idmenu, a.desmenu, a.desicon, a.deshref, a.nrorder, a.dtregister, a.nrsubmenus
	ORDER BY a.nrorder;
    
END