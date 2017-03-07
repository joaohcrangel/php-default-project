CREATE PROCEDURE sp_adressestypes_get(
pidadresstype INT
)
BEGIN

    SELECT *    
    FROM tb_adressestypes    
    WHERE idadresstype = pidadresstype;

END