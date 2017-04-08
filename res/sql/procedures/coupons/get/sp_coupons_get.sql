CREATE PROCEDURE sp_coupons_get(
pidcoupon INT
)
BEGIN

    SELECT *    
    FROM tb_coupons    
    WHERE idcoupon = pidcoupon;

END