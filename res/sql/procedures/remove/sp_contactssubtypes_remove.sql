CREATE PROCEDURE sp_contactssubtypes_remove(
pidcontactsubtype INT
)
BEGIN

    DELETE FROM tb_contactssubtypes 
    WHERE idcontactsubtype = pidcontactsubtype;

END