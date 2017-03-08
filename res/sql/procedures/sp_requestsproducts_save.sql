CREATE PROCEDURE sp_requestsproducts_save(
pidrequest INT,
pidproduct INT,
pnrqtd INT,
pvlprice DEC(10,2),
pvltotal DEC(10,2)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_requestsproducts WHERE idrequest = pidrequest AND idproduct = pidproduct) THEN
    
		UPDATE tb_requestsproducts SET
			nrqtd = pnrqtd,
            vlprice = pvlprice,
            vltotal = pvltotal
		WHERE idrequest = pidrequest AND idproduct = pidproduct;
        
	ELSE
    
		INSERT INTO tb_pedidosprodutos(idrequest, idproduct, nrqtd, vlprice, vltotal)
        VALUES(pidrequest, pidproduct, pnrqtd, pvlprice, pvltotal);
        
	END IF;
    
    CALL sp_requestsproducts_get(pidrequest, pidrequest);
    
END