CREATE PROCEDURE sp_sitesmenus_remove(
pidmenu INT
)
BEGIN

    DELETE FROM tb_sitesmenus WHERE idmenu = pidmenu;

END