CREATE PROCEDURE sp_emails_get(
pidemail INT
)
BEGIN

    SELECT *    
    FROM tb_emails    
    WHERE idemail = pidemail;

END