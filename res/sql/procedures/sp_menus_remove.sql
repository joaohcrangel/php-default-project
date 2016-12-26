CREATE PROCEDURE sp_menus_remove(
pidmenu INT
)
BEGIN

    DELETE FROM tb_menus WHERE idmenu = pidmenu;

END