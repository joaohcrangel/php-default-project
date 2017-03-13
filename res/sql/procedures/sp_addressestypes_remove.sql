CREATE PROCEDURE sp_addressestypes_remove(
pidaddresstype INT
)
BEGIN

    DELETE FROM tb_addressestypes 
    WHERE idaddresstype = pidaddresstype;

END