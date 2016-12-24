CREATE PROCEDURE sp_menusfromusuario_list(
pidusuario INT
)
BEGIN
	
    SELECT
	CASE WHEN a.idmenupai IS NULL THEN 0 ELSE a.idmenupai END idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, a.nrsubmenus,
	CASE WHEN b.desmenu IS NULL THEN 'Root' ELSE b.desmenu END AS desmenupai
	FROM tb_menus a
	LEFT JOIN tb_menus b ON b.idmenu = a.idmenupai
	INNER JOIN tb_permissoesmenus c ON c.idmenu = a.idmenu
	INNER JOIN tb_permissoesusuarios d ON d.idpermissao = c.idpermissao
	WHERE
		d.idusuario = pidusuario
	GROUP BY a.idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, a.nrsubmenus
	ORDER BY a.nrordem;
    
END