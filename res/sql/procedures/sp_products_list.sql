CREATE PROCEDURE sp_products_list()
BEGIN

	SELECT * FROM tb_products a INNER JOIN tb_productstypes USING(idproducttipo)
	WHERE a.inremoved = 0;

END