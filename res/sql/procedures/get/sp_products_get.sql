CREATE PROCEDURE sp_products_get(
pidproduct INT
)
BEGIN

    SELECT *    
    FROM tb_products    
    WHERE idproduct = pidproduct;

END;