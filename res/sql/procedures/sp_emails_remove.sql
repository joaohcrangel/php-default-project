CREATE PROCEDURE sp_emails_remove(
pidemail INT
)
BEGIN

    DELETE FROM tb_emails 
    WHERE idemail = pidemail;

END