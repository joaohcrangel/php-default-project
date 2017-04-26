CREATE PROCEDURE sp_gateways_save(
pidgateway INT,
pdesgateway VARCHAR(128)
)
BEGIN
	
	IF pidgateway = 0 THEN
    
		INSERT INTO tb_gateways(desgateway) VALUES(pdesgateway);
        
        SET pidgateway = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_gateways SET
			desgateway = pdesgateway
		WHERE idgateway = pidgateway;
        
	END IF;
    
    CALL sp_gateways_get(pidgateway);

END