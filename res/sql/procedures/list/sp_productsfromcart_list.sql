CREATE PROCEDURE sp_productsfromcart_list(
pidcart INT
)
BEGIN

	SELECT a.idproduct, b.idproducttype, b.desproducttype, b.desproduct, b.vlprice, count(b.idproduct) AS nrqtd, count(b.idproduct)*b.vlprice AS vltotal, b.desurl
	FROM tb_cartsproducts a
	INNER JOIN tb_productsdata b ON a.idproduct = b.idproduct
	WHERE a.idcart = pidcart AND a.dtremoved IS NULL
	GROUP BY a.idproduct
	ORDER BY b.desproduct;

END