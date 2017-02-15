CREATE PROCEDURE sp_pedidosprodutos_get(
pidpedido INT,
pidproduto INT
)
BEGIN
	
	SELECT * FROM tb_pedidosprodutos a
		INNER JOIN tb_pedidos b ON a.idpedido = b.idpedido
		INNER JOIN tb_produtos c ON c.idproduto = a.idproduto
	WHERE a.idpedido = pidpedido AND a.idproduto = pidproduto AND c.inremovido = 0;
    
END