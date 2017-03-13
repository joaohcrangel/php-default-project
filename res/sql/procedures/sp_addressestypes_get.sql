CREATE PROCEDURE sp_addressestypes_get(
pidaddresstype INT
)
BEGIN

    SELECT *    
    FROM tb_addressestypes    
    WHERE idaddresstype = pidaddresstype;

END