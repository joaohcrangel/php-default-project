CREATE PROCEDURE sp_coupons_list()
BEGIN

    SELECT *
    FROM tb_coupons
    INNER JOIN tb_couponstypes USING(idcoupontype);

END