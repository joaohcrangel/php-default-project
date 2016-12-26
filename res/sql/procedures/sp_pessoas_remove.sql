CREATE PROCEDURE sp_pessoas_remove(
pidpessoa INT
)
BEGIN
	
    DELETE FROM tb_pessoas WHERE idpessoa = pidpessoa;

END