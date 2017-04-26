CREATE PROCEDURE sp_addresses_remove(
pidaddress INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_personsaddresses WHERE idaddress = pidaddress) THEN
    
		DELETE FROM tb_personsaddresses WHERE idaddress = pidaddress;
        
	END IF;

	IF EXISTS(SELECT * FROM tb_placesaddresses WHERE idaddress = pidaddress) THEN

		DELETE FROM tb_placesaddresses WHERE idaddress = pidaddress;

	END IF;

	IF EXISTS(SELECT * FROM tb_placesdata WHERE idaddress = pidaddress) THEN

		UPDATE tb_placesdata SET
			idaddresstype = NULL,
			desaddresstype = NULL,
			idaddress = NULL,
			desaddress = NULL,
			desnumber = NULL,
			desdistrict = NULL,
			descity = NULL,
			desstate = NULL,
			descountry = NULL,
			descep = NULL,
			descomplement = NULL
		WHERE idaddress = pidaddress;

	END IF;

    DELETE FROM tb_addresses WHERE idaddress = pidaddress;

END