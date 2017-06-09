CREATE PROCEDURE sp_formspayments_save(
pidformpayment INT,
pidgateway INT,
pdesformpayment VARCHAR(128),
pnrparcelsmax INT,
pinstatus BIT
)
BEGIN
	
	IF pidformpayment = 0 THEN
    
		INSERT INTO tb_formspayments(idgateway, desformpayment, nrparcelsmax, instatus)
        VALUES(pidgateway, pdesformpayment, pnrparcelsmax, pinstatus);
        
        SET pidformpayment = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_formspayments SET
			idgateway = pidgateway,
            desformpayment = pdesformpayment,
            nrparcelsmax = pnrparcelsmax,
            instatus = pinstatus
		WHERE idformpayment = pidformpayment;
        
	END IF;
    
    CALL sp_formspayments_get(pidformpayment);

END