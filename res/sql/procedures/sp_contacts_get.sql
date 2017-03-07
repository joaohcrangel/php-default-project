CREATE PROCEDURE sp_contacts_get(
pidcontact INT
)
BEGIN

    SELECT *    
    FROM tb_contacts    
    WHERE idcontact = pidcontact;

END