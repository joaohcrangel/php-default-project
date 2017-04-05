CREATE PROCEDURE sp_emailsattachments_get(
pidemail INT
)
BEGIN

    SELECT *    
    FROM tb_emailsattachments    
    WHERE idemail = pidemail;

END