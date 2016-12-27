CREATE PROCEDURE sp_permissoesfrommenusfaltantes_list(
pidmenu INT
)
BEGIN
	
	SELECT *
	FROM tb_permissoes a
	WHERE a.idpermissao NOT IN(
		SELECT a1.idpermissao
		FROM tb_permissoes a1
		INNER JOIN tb_permissoesmenus b1 ON a1.idpermissao = b1.idpermissao
		WHERE b1.idmenu = pidmenu
	)
	ORDER BY a.despermissao;
    
END