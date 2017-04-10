CREATE PROCEDURE sp_pedidosfromproduto_list(
pidproduto INT
)
BEGIN

	SELECT * FROM tb_pedidosprodutos a
		INNER JOIN tb_pedidos b ON a.idpedido = b.idpedido
        INNER JOIN tb_produtos c ON a.idproduto = c.idproduto
	WHERE a.idproduto = pidproduto;

END