CREATE PROCEDURE sp_cartsfreights_save(
idcart INT,
deszipcode CHAR(8),
vlfreight INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_cartsfreights WHERE idcart = pidcart) THEN

    	INSERT INTO tb_cartsfreights(idcart, deszipcode, vlfreight)
    	VALUES(pidcart, pdeszipcode, pvlfreight);

    ELSE

    	UPDATE tb_cartsfreights SET
    		deszipcode = pdeszipcode,
    		vlfreight = pvlfreight
    	WHERE idcart = pidcart;

    END IF;

    CALL sp_cartsfreights_get(idcart);

END