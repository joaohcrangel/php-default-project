CREATE PROCEDURE sp_coupons_remove(
pidcoupon INT
)
BEGIN

    DELETE FROM tb_coupons 
    WHERE idcoupon = pidcoupon;

END