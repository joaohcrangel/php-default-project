CREATE PROCEDURE sp_pessoas_remove(
pidpessoa INT
)
BEGIN
	
	UPDATE tb_pessoas
	SET inremovido = 1
	WHERE idpessoa = pidpessoa;

END