CREATE PROCEDURE sp_pessoa_remove(
pidpessoa INT
)
BEGIN
	
    DELETE FROM tb_pessoas WHERE idpessoa = pidpessoa;

END