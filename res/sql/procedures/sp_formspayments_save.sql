CREATE PROCEDURE sp_formspayments_save(
pidformpayment INT,
pidgateway INT,
pdesformpayment VARCHAR(128),
pnrplotsmax INT,
pinstatus BIT
)
BEGIN
	
	IF pidformpayment = 0 THEN
    
		INSERT INTO tb_formspayments(idgateway, desformspayments, nrplotsmax, instatus)
        VALUES(pidgateway, pdesformspayments, pnrplotsmax, pinstatus);
        
        SET pidformpayment = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_formspayments SET
			idgateway = pidgateway,
            desformpayment = pdesformpayment,
            nrplotsmax = pnrplotsmax,
            instatus = pinstatus
		WHERE idformpayment = pidformpayment;
        
	END IF;
    
    CALL sp_formspayments_get(pidformspayments);

END