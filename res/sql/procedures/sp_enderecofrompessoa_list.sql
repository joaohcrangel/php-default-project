CREATE PROCEDURE sp_enderecofrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * 
	FROM tb_enderecos a
	INNER JOIN tb_enderecostipos b ON a.idenderecotipo = b.idenderecotipo 
	WHERE idpessoa = pidpessoa 
	ORDER BY desendereco;

END