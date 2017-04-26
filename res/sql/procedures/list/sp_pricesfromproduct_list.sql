CREATE PROCEDURE sp_pricesfromproduct_list(
pidproduct INT
)
BEGIN

	SELECT * 
    FROM tb_productsprices
	INNER JOIN tb_products USING(idproduct)
    WHERE idproduct = pidproduct
    ORDER BY dtstart DESC, dtend DESC;

END