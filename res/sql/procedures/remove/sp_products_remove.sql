CREATE PROCEDURE sp_products_remove(
pidproduct INT
)
BEGIN

    DELETE FROM tb_products 
    WHERE idproduct = pidproduct;

END;