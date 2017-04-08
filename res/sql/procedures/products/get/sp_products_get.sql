CREATE PROCEDURE sp_products_get(
pidproduct INT
)
BEGIN

	SELECT *
	FROM tb_productsdata
    WHERE idproduct = pidproduct;

END