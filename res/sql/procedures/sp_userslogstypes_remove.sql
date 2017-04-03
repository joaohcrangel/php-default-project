CREATE PROCEDURE sp_userslogstypes_remove(
pidlogtype INT
)
BEGIN

    DELETE FROM tb_userslogstypes 
    WHERE idlogtype = pidlogtype;

END