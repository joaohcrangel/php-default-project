CREATE PROCEDURE sp_pessoashistoricos_remove(
pidpessoahistorico INT
)
BEGIN

    DELETE FROM tb_pessoashistoricos 
    WHERE idpessoahistorico = pidpessoahistorico;

END