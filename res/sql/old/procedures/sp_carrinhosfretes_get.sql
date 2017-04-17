CREATE PROCEDURE sp_cartsproducts_get(
pidcart INT
)
BEGIN

    SELECT *    
    FROM tb_cartsproducts    
    WHERE idcart = pidcart;

END