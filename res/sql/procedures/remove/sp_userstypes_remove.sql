CREATE PROCEDURE sp_userstypes_remove(
pidusertype INT
)
BEGIN

    DELETE FROM tb_userstypes 
    WHERE idusertype = pidusertype;

END