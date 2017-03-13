CREATE PROCEDURE sp_receiptsfromorder_list(
pidorder INT
)
BEGIN

	SELECT * FROM tb_ordersreceipts
		INNER JOIN tb_orders USING(idorder)
	WHERE idorder = pidorder;

END