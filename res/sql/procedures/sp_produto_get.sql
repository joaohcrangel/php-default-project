CREATE PROCEDURE sp_produto_get(
pidproduto INT
)
BEGIN

	SELECT * FROM tb_produtos WHERE idproduto = pidproduto;

END