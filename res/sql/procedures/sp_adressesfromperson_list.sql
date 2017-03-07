CREATE PROCEDURE sp_adressesfromperson_list(
pidperson INT
)
BEGIN

	SELECT * 
	FROM tb_adresses a
		INNER JOIN tb_adressestypes b ON a.idadresstype = b.idadresstype
	    INNER JOIN tb_personsadresses c ON a.idadress = c.idadress
	WHERE c.idperson = pidperson
	ORDER BY desadress;

END