CREATE PROCEDURE sp_couponstypes_remove(
pidcoupontype INT
)
BEGIN

    DELETE FROM tb_couponstypes 
    WHERE idcoupontype = pidcoupontype;

END