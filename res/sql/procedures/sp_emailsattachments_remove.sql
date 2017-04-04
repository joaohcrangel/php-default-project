CREATE PROCEDURE sp_emailsattachments_remove(
pidemail INT
)
BEGIN

    DELETE FROM tb_emailsattachments 
    WHERE idemail = pidemail;

END