CREATE PROCEDURE sp_produto_remove(
pidproduto INT
)
BEGIN

	DELETE FROM tb_produtos WHERE idproduto = pidproduto;

END