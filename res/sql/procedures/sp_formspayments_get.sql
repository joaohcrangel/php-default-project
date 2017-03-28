CREATE PROCEDURE sp_formspayments(
pidformpayment INT
)
BEGIN
 SELECT *    
    FROM tb_formspayment    
    WHERE idformpayment = pidformpayment;
END