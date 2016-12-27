CREATE PROCEDURE sp_permissoesmenus_remove(
pidpermissao INT,
pidmenu INT
)
BEGIN

	DELETE FROM tb_permissoesmenus
    WHERE 
		idmenu = pidmenu
        AND
        idpermissao = pidpermissao;

END