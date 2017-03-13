CREATE PROCEDURE sp_addresses_remove(
pidaddress INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_personsaddresses WHERE idaddress = pidaddress) THEN
    
		DELETE FROM tb_personsaddresses WHERE idaddress = pidaddress;
        
	END IF;

    DELETE FROM tb_addresses WHERE idaddress = pidaddress;

END