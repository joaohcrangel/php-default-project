CREATE PROCEDURE sp_cartsfreights_get(
pidcart INT
)
BEGIN

    SELECT *    
    FROM tb_cartsfreights    
    WHERE idcart = pidcart;

END