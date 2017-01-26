CREATE PROCEDURE sp_carrinhosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * FROM tb_carrinhos WHERE idpessoa = pidpessoa;

END