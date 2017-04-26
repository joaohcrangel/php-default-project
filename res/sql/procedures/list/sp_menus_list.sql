CREATE PROCEDURE sp_menus_list()
BEGIN

    SELECT
    CASE WHEN a.idmenufather IS NULL THEN 0 ELSE a.idmenufather END idmenufather, a.idmenu, a.desmenu, a.desicon, a.deshref, a.nrorder, a.dtregister, a.nrsubmenus,
    CASE WHEN b.desmenu IS NULL THEN 'Root' ELSE b.desmenu END AS desmenufather
    FROM tb_menus a
    LEFT JOIN tb_menus b ON b.idmenu = a.idmenufather
    ORDER BY a.nrorder;

END