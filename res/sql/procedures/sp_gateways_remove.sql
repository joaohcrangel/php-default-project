CREATE PROCEDURE sp_gateways_remove(
pidgateway INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_formaspagamentos WHERE idgateway = pidgateway) THEN
    
		DELETE FROM tb_formaspagamentos WHERE idgateway = pidgateway;
        
	END IF;
    
    DELETE FROM tb_gateways WHERE idgateway = pidgateway;

END