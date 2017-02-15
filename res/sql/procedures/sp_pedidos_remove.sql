CREATE PROCEDURE sp_pedidos_remove(
pidpedido INT
)
BEGIN
	
	DELETE FROM tb_pedidos WHERE idpedido = pidpedido;
    
END