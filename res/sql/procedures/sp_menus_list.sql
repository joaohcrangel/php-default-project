CREATE PROCEDURE sp_menus_list()
BEGIN

    SELECT
    CASE WHEN a.idmenupai IS NULL THEN 0 ELSE a.idmenupai END idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, a.nrsubmenus,
    CASE WHEN b.desmenu IS NULL THEN 'Root' ELSE b.desmenu END AS desmenupai
    FROM tb_menus a
    LEFT JOIN tb_menus b ON b.idmenu = a.idmenupai
    ORDER BY a.nrordem;

END