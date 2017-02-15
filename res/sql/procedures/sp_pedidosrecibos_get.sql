CREATE PROCEDURE sp_pedidosrecibos_get(
pidpedido INT
)
BEGIN
	
	SELECT * FROM tb_pedidosrecibos a INNER JOIN tb_pedidos USING(idpedido)
    WHERE a.idpedido = pidpedido;
    
END