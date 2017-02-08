CREATE PROCEDURE sp_enderecosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * 
	FROM tb_enderecos a
		INNER JOIN tb_enderecostipos b ON a.idenderecotipo = b.idenderecotipo
	    INNER JOIN tb_pessoasenderecos c ON a.idendereco = c.idendereco
	WHERE c.idpessoa = pidpessoa
	ORDER BY desendereco;

END