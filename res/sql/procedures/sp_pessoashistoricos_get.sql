CREATE PROCEDURE sp_pessoashistoricos_get(
pidpessoahistorico INT
)
BEGIN

    SELECT *    
    FROM tb_pessoashistoricos    
    WHERE idpessoahistorico = pidpessoahistorico;

END