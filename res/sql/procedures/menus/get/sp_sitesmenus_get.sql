CREATE PROCEDURE sp_sitesmenus_get(
pidmenu INT
)
BEGIN

    SELECT
    a.idmenufather, a.idmenu, a.desmenu, a.desicon, a.deshref, a.nrorder, a.dtregister, a.nrsubmenus,
    b.desmenu AS desmenufather
    FROM tb_sitesmenus a
    LEFT JOIN tb_sitesmenus b ON b.idmenu = a.idmenufather
    WHERE a.idmenu = pidmenu;

END