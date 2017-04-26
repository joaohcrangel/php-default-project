CREATE PROCEDURE sp_orders_remove(
pidorder INT
)
BEGIN
	
	DELETE FROM tb_orders WHERE idorder = pidorder;
    
END