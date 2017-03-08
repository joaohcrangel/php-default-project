CREATE PROCEDURE sp_formspayments_list()
BEGIN
	
	SELECT * FROM tb_formspayments INNER JOIN tb_gateways USING(idgateway);

END