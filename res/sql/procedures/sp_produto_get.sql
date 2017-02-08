CREATE PROCEDURE sp_produto_get(
pidproduto INT
)
BEGIN

	SELECT a.*, b.idpreco, b.vlpreco FROM tb_produtos a
		LEFT JOIN tb_produtosprecos b USING(idproduto)
    WHERE idproduto = pidproduto;

END