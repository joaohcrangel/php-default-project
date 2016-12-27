CREATE PROCEDURE sp_permissoesfrommenus_list(
pidmenu INT
)
BEGIN
    
    SELECT *
    FROM tb_permissoes a
    INNER JOIN tb_permissoesmenus b ON a.idpermissao = b.idpermissao
    WHERE b.idmenu = pidmenu
    ORDER BY a.despermissao;
    
END