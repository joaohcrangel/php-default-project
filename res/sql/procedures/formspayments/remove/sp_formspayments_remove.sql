CREATE PROCEDURE sp_formspayments_remove(
pidformpayment INT
)
BEGIN
	
	DELETE FROM tb_formspayments WHERE idformpayment = pidformpayment;

END