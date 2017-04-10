CREATE PROCEDURE sp_addresses_get(
pidaddress INT
)
BEGIN

    SELECT *    
    FROM tb_addresses    
    WHERE idaddress = pidaddress;

END