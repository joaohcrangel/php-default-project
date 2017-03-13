CREATE PROCEDURE sp_cartsproducts_list()
BEGIN
	
	SELECT a.idcart, a.dessession, a.vltotal, b.idproduct, b.desproduct, c.inremoved, d.idperson, d.desperson
	FROM tb_cartsproducts c
        INNER JOIN tb_carts a ON a.idcart = c.idcart
        INNER JOIN tb_products b ON b.idproduct = c.idproduct
        INNER JOIN tb_persons d ON a.idperson = d.idperson
    WHERE b.inremoved = 0;

END