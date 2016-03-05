CREATE PROCEDURE sp_usuario_get(
pidusuario INT
)
BEGIN

    SELECT
	a.idusuario, a.idpessoa, a.desusuario, a.dessenha, a.inbloqueado, a.dtcadastro,
	GROUP_CONCAT(b.idpermissao) AS despermissoes
	FROM tb_usuarios a
	INNER JOIN tb_permissoesusuarios b ON a.idusuario = b.idusuario
	WHERE a.idusuario = pidusuario
	GROUP BY a.idusuario, a.idpessoa, a.desusuario, a.dessenha, a.inbloqueado, a.dtcadastro;

END