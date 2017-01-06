CREATE PROCEDURE sp_formaspagamentos_list()
BEGIN
	
	SELECT * FROM tb_formaspagamentos INNER JOIN tb_gateways USING(idgateway);

END