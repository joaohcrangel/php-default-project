CREATE PROCEDURE sp_ordersreceipts_get(
idorder INT
)
BEGIN
	
	SELECT * FROM tb_ordersreceipts a INNER JOIN tb_orders USING(idorder)
    WHERE a.idorder = idorder;
    
END