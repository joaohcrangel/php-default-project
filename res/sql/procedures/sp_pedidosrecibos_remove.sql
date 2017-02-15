CREATE PROCEDURE sp_pedidosrecibos_remove(
pidpedido INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pedidosrecibos WHERE idpedido = pidpedido) THEN
    
		DELETE FROM tb_pedidosrecibos WHERE idpedido = pidpedido;
        
	END IF;
    
END