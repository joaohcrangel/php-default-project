CREATE PROCEDURE sp_gateways_get(
pidgateway INT
)
BEGIN
	
	SELECT * FROM tb_gateways WHERE idgateway = pidgateway;

END