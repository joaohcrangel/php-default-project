CREATE PROCEDURE sp_formspayments_get(
pidformpayment INT
)
BEGIN
	
	SELECT * FROM tb_formspayments a INNER JOIN tb_gateways USING(idgateway)
    WHERE a.idformpayment = pidformpayment;

END