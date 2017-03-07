CREATE PROCEDURE sp_adressestypes_remove(
pidadresstype INT
)
BEGIN

    DELETE FROM tb_adressestypes 
    WHERE idadresstype = pidadresstype;

END