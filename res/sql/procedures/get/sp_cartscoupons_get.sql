CREATE PROCEDURE sp_cartscoupons_get(
pidcart INT,
pidcoupon INT
)
BEGIN

    SELECT *    
    FROM tb_cartscoupons    
    WHERE idcart = pidcart AND idcoupon = pidcoupon;

END