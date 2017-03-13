CREATE PROCEDURE sp_cartscoupons_save(
pidcart INT,
pidcoupon INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_cartscoupons WHERE idcart = pidcart AND idcoupon = pidcoupon) THEN

    	INSERT INTO tb_cartscoupons(idcart, idcoupon)
    	VALUES(pidcart, pidcoupon);

    END IF;

END