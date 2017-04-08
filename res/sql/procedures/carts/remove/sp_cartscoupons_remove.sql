CREATE PROCEDURE sp_cartscoupons_remove(
pidcart INT,
pidcoupon INT
)
BEGIN

    DELETE FROM tb_cartscoupons 
    WHERE idcart = pidcart AND idcoupon = pidcoupon;

END