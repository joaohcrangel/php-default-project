CREATE PROCEDURE sp_cartsfromproduct_list(
pidproduct INT
)
BEGIN

	SELECT * FROM tb_cartsproducts a
		INNER JOIN tb_products b ON a.idproduct = b.idproduct
        INNER JOIN tb_carts c ON a.idcart = c.idcart
	WHERE a.idproduct = pidproduct;

END