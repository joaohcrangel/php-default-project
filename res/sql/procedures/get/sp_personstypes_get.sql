CREATE PROCEDURE sp_personstypes_get(
pidpersontype INT
)
BEGIN

    SELECT *    
    FROM tb_personstypes    
    WHERE idpersontype = pidpersontype;

END