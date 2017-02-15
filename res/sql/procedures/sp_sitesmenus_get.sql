CREATE PROCEDURE sp_sitesmenus_get(
pidmenu INT
)
BEGIN

    SELECT
    a.idmenupai, a.idmenu, a.desmenu, a.desicone, a.deshref, a.nrordem, a.dtcadastro, a.nrsubmenus,
    b.desmenu AS desmenupai
    FROM tb_sitesmenus a
    LEFT JOIN tb_sitesmenus b ON b.idmenu = a.idmenupai
    WHERE a.idmenu = pidmenu;

END