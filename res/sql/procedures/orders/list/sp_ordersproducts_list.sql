CREATE PROCEDURE sp_ordersproducts_list()
BEGIN
	
	SELECT * FROM tb_ordersproducts a
    INNER JOIN tb_orders b ON a.idorder = b.idorder
    INNER JOIN tb_products c ON c.idproduct = a.idproduct;
    
END