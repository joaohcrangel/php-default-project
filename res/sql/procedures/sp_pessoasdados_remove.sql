CREATE PROCEDURE sp_pessoasdados_remove (
pidpessoa INT
)
BEGIN
	
	DELETE FROM tb_pessoasdados WHERE idpessoa = pidpessoa;
    
END