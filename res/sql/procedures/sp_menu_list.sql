CREATE PROCEDURE sp_menu_list()
BEGIN

    SELECT
    a.idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, (
		SELECT COUNT(*)
        FROM tb_menus b
        WHERE b.idmenupai = a.idmenu
    ) AS nrsubmenu
    FROM tb_menus a
    ORDER BY a.nrordem;

END