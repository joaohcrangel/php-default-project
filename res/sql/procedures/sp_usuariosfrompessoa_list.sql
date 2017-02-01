CREATE PROCEDURE sp_usuariosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT a.*, b.despessoa, b.despessoatipo, c.* FROM tb_usuarios a
		INNER JOIN tb_pessoasdados b ON a.idpessoa = b.idpessoa
        INNER JOIN tb_usuariostipos c ON a.idusuariotipo = c.idusuariotipo
	WHERE a.idpessoa = pidpessoa;

END