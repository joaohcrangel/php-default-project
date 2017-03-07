CREATE PROCEDURE sp_carts_get(
pidcart INT
)
BEGIN

    SELECT *    
    FROM tb_carts    
    WHERE idcart = pidcart;

END