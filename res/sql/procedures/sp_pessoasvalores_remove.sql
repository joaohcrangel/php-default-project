CREATE PROCEDURE sp_pessoasvalores_remove(
pidpessoavalor INT
)
BEGIN

	DELETE FROM tb_pessoasvalores WHERE idpessoavalor = pidpessoavalor;

END