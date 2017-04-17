CREATE PROCEDURE sp_ordersreceipts_list()
BEGIN
	
	SELECT * FROM tb_ordersreceipts INNER JOIN tb_orders USING(idorder);
    
END