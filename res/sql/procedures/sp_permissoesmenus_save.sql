CREATE PROCEDURE sp_permissoesmenus_save(
pidpermissao INT,
pidmenu INT
)
BEGIN
    
    IF NOT EXISTS(SELECT * FROm tb_permissoesmenus WHERE idpermissao = pidpermissao AND idmenu = pidmenu) THEN
        INSERT INTO tb_permissoesmenus (idpermissao, idmenu)
        VALUES(pidpermissao, pidmenu);
    END IF;

    CALL sp_permissoes_get(pidpermissao);

END