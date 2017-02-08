CREATE PROCEDURE sp_produto_remove(
pidproduto INT
)
BEGIN

	UPDATE tb_produtos SET
		inremovido = 1
	WHERE idproduto = pidproduto;

END