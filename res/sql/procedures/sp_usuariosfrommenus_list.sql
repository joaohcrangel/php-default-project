CREATE PROCEDURE sp_usuariosfrommenus_list(
pidmenu INT
)
BEGIN

	SELECT * 
	FROM tb_usuarios a
	INNER JOIN tb_permissoesusuarios b ON a.idusuario = b.idusuario
	INNER JOIN tb_permissoesmenus c ON c.idpermissao = b.idpermissao
	INNER JOIN tb_pessoasdados d ON d.idpessoa = a.idpessoa
	WHERE c.idmenu = pidmenu
	ORDER BY d.despessoa;

END