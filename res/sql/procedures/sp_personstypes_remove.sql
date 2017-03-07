CREATE PROCEDURE sp_personstypes_remove(
pidpersontype INT
)
BEGIN

    DELETE FROM tb_personstypes 
    WHERE idpersontype = pidpersontype;

END