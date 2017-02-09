CREATE PROCEDURE sp_produto_get(
pidproduto INT
)
BEGIN

	SELECT *
	FROM tb_produtosdados
    WHERE idproduto = pidproduto;

END