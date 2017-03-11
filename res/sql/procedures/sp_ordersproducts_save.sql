CREATE PROCEDURE sp_ordersproducts_save(
pidorder INT,
pidproduct INT,
pnrqtd INT,
pvlprice DEC(10,2),
pvltotal DEC(10,2)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_ordersproducts WHERE idorder = pidorder AND idproduct = pidproduct) THEN
    
		UPDATE tb_ordersproducts SET
			nrqtd = pnrqtd,
            vlprice = pvlprice,
            vltotal = pvltotal
		WHERE idorder = pidorder AND idproduct = pidproduct;
        
	ELSE
    
		INSERT INTO tb_ordersproducts(idorder, idproduct, nrqtd, vlprice, vltotal)
        VALUES(pidorder, pidproduct, pnrqtd, pvlprice, pvltotal);
        
	END IF;
    
    CALL sp_ordersproducts_get(pidorder, pidorder);
    
END