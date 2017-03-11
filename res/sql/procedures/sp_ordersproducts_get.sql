CREATE PROCEDURE sp_ordersproducts_get(
pidorder INT,
pidproduct INT
)
BEGIN
	
	SELECT * FROM tb_ordersproducts a
		INNER JOIN tb_orders b ON a.idorder = b.idorder
		INNER JOIN tb_products c ON c.idproduct = a.idproduct
	WHERE a.idorder = pidorder AND a.idproduct = pidproduct AND c.inremoved= 0;
    
END