CREATE PROCEDURE sp_pedidosprodutos_list()
BEGIN
	
	SELECT * FROM tb_pedidosprodutos a
    INNER JOIN tb_pedidos b ON a.idpedido = b.idpedido
    INNER JOIN tb_produtos c ON c.idproduto = a.idproduto;
    
END