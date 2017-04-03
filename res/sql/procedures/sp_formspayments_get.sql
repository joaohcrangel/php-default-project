CREATE PROCEDURE sp_formspayments_get(
pidformpayment INT
)
BEGIN
 SELECT *    
    FROM tb_formspayments    
    WHERE idformpayment = pidformpayment;
END