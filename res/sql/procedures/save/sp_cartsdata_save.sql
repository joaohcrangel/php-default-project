CREATE PROCEDURE sp_cartsdata_save(
pidcart INT
)
BEGIN

	DECLARE pvlprice DECIMAL(10,2);
    DECLARE pnrproducts INT;		
    DECLARE pidcoupontype INT;
	DECLARE pnrdiscount DEC(10,2);
    
    SELECT SUM(c.vlprice) AS vltotal, COUNT(c.idproduct) AS nrproducts INTO pvlprice, pnrproducts FROM tb_carts a
		INNER JOIN tb_cartsproducts b ON a.idcart = b.idcart
		INNER JOIN tb_productsprices c ON b.idproduct = c.idproduct
	WHERE a.idcart = pidcart AND b.dtremovido IS NULL;
    
    UPDATE tb_carts SET
		vltotal = pvlprice,
        vltotalgross = pvlprice,
        nrproducts = pnrproducts
	WHERE idcart = pidcart;
    
    
    /* Atualizando o valor do cart com o frete */
    IF EXISTS(SELECT * FROM tb_cartsfreights WHERE idcart = pidcart) THEN
		UPDATE tb_carts SET
			vltotal = vltotal + (SELECT vlfreight FROM tb_cartsfreights WHERE idcart = pidcart),
            vltotalgross = vltotalgross + (SELECT vlfreight FROM tb_cartsfreights WHERE idcart = pidcart)
		WHERE idcart = pidcart;
	END IF;
    
    
    /* Atualizando o valor do cart com coupom */
    IF EXISTS(SELECT * FROM tb_cartscoupons WHERE idcart = pidcart) THEN
		
		SELECT a.idcoupontype, b.nrdiscount INTO pidcoupontype, pnrdiscount FROM tb_couponstypes a
			INNER JOIN tb_coupons b ON a.idcoupontype = b.idcoupontype
			INNER JOIN tb_cartscoupons c ON b.idcoupon = c.idcoupon
		WHERE c.idcart = pidcart;
		
		IF pidcoupontype = 1 THEN
		
			UPDATE tb_carts SET
				vltotal = vltotal - pnrdiscount
			WHERE idcart = pidcart;
		
		ELSE
		
			UPDATE tb_carts SET
				vltotal = vltotal - ((vltotal * pnrdiscount) / 100)
			WHERE idcart = pidcart;
											
		END IF;
		
	END IF;
    

END