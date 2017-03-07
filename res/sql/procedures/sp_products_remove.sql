CREATE PROCEDURE sp_products_remove(
pidproduct INT
)
BEGIN

	UPDATE tb_products SET
		inremoved = 1
	WHERE idproduct = pidproduct;

END