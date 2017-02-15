CREATE PROCEDURE sp_pedidosrecibos_list()
BEGIN
	
	SELECT * FROM tb_pedidosrecibos INNER JOIN tb_pedidos USING(idpedido);
    
END