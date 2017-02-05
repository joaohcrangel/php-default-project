CREATE PROCEDURE sp_produto_get(
pidproduto INT
)
BEGIN

	SELECT * FROM tb_produtos
		INNER JOIN tb_produtosprecos USING(idproduto)
    WHERE idproduto = pidproduto;

END