CREATE PROCEDURE sp_ordersfromproduct_list(
pidproduct INT
)
BEGIN

	SELECT * FROM tb_ordersproducts a
		INNER JOIN tb_orders b ON a.idorder = b.idorder
        INNER JOIN tb_products c ON a.idproduct = c.idproduct
	WHERE a.idproduct = pidproduct;

END