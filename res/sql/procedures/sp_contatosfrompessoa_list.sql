CREATE PROCEDURE sp_contatosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * 
	FROM tb_contatos a
	INNER JOIN tb_contatostipos b ON a.idcontatotipo = b.idcontatotipo 
	WHERE idpessoa = pidpessoa 
	ORDER BY descontato;

END