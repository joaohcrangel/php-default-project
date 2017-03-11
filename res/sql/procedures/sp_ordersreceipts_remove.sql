CREATE PROCEDURE sp_ordersreceipts_remove(
pidorder INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_ordersreceipts WHERE idorder = pidorder) THEN
    
		DELETE FROM tb_ordersreceipts WHERE idorder = pidorder;
        
	END IF;
    
END