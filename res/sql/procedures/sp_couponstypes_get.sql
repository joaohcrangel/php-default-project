CREATE PROCEDURE sp_couponstypes_get(
pidcoupontype INT
)
BEGIN

    SELECT *    
    FROM tb_couponstypes    
    WHERE idcoupontype = pidcoupontype;

END