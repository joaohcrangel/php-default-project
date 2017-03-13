CREATE PROCEDURE sp_addressesfromperson_list(
pidperson INT
)
BEGIN

	SELECT * 
	FROM tb_addresses a
		INNER JOIN tb_addressestypes b ON a.idaddresstype = b.idaddresstype
	    INNER JOIN tb_personsaddresses c ON a.idaddress = c.idaddress
	WHERE c.idperson = pidperson
	ORDER BY desaddress;

END