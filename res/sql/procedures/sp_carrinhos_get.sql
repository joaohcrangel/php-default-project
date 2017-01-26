CREATE PROCEDURE sp_carrinhos_get (
pidcarrinho INT
)
BEGIN
	
	SELECT * FROM tb_carrinhos WHERE idcarrinho = pidcarrinho;

END