CREATE PROCEDURE sp_menu_get(
pidmenu INT
)
BEGIN

    SELECT
    a.idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, (
		SELECT COUNT(*)
        FROM tb_menus b
        WHERE b.idmenupai = a.idmenu
    ) AS nrsubmenu
    
    FROM tb_menus a

    WHERE a.idmenu = pidmenu;

END