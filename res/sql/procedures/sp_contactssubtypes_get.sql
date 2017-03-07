CREATE PROCEDURE sp_contactssubtypes_get(
pidcontactsubtype INT
)
BEGIN

    SELECT *    
    FROM tb_contactssubtypes    
    WHERE idcontactsubtype = pidcontactsubtype;

END