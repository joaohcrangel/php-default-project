CREATE PROCEDURE sp_contatosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * 
	FROM tb_contatos a
	INNER JOIN tb_contatossubtipos b ON a.idcontatosubtipo = b.idcontatosubtipo 
	INNER JOIN tb_contatostipos c ON c.idcontatotipo = b.idcontatotipo 
	WHERE idpessoa = pidpessoa 
	ORDER BY descontato;

END