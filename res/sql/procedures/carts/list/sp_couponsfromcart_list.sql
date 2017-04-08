CREATE PROCEDURE sp_couponsfromcart_list(
pidcart INT
)
BEGIN

	SELECT a.*, b.idcart, c.descoupontype FROM tb_coupons a
		INNER JOIN tb_cartscoupons b ON a.idcoupon = b.idcoupon
        INNER JOIN tb_couponstypes c ON a.idcoupontype = c.idcoupontype
	WHERE b.idcart = pidcart;

END