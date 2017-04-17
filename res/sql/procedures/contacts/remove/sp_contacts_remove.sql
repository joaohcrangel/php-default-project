CREATE PROCEDURE sp_contacts_remove(
pidcontact INT
)
BEGIN

    DELETE FROM tb_contacts 
    WHERE idcontact = pidcontact;

END