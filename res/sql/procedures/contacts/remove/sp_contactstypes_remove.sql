CREATE PROCEDURE sp_contactstypes_remove(
pidcontacttype INT
)
BEGIN

    DELETE FROM tb_contactstypes 
    WHERE idcontacttype = pidcontacttype;

END