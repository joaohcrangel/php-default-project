CREATE PROCEDURE sp_productsfromcart_list(
pidcart INT
)
BEGIN

	SELECT a.*, b.desperson, c.dtremoved, d.idproduct, d.desproduct, d.desproducttype, d.vlprice FROM tb_carts a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
        INNER JOIN tb_cartsproducts c ON a.idcart = c.idcart
        INNER JOIN tb_productsdata d ON c.idproduct = d.idproduct
	WHERE a.idcart = pidcart;

END