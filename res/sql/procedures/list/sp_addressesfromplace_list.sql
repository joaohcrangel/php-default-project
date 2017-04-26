CREATE PROCEDURE sp_addressesfromplace_list(
pidplace INT
)
BEGIN

	SELECT a.*, a1.desaddresstype, c.desplace FROM tb_addresses a
		INNER JOIN tb_addressestypes a1 ON a1.idaddresstype = a.idaddresstype
		INNER JOIN tb_placesaddresses b ON a.idaddress = b.idaddress
        INNER JOIN tb_places c ON c.idplace = b.idplace        
	WHERE c.idplace = pidplace ORDER BY a.desaddress;

END