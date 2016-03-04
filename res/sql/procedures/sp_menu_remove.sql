CREATE PROCEDURE sp_menu_remove(
pidmenu INT
)
BEGIN

    DELETE FROM tb_menus WHERE idmenu = pidmenu;

END