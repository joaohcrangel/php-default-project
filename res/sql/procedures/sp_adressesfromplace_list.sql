CREATE PROCEDURE sp_adressesfromplace_list(
pidplace INT
)
BEGIN

	SELECT a.*, a1.desadresstype, c.desplace FROM tb_adresses a
		INNER JOIN tb_adressestypes a1 ON a1.idadresstype = a.idadresstype
		INNER JOIN tb_placesadresses b ON a.idadress = b.idadress
        INNER JOIN tb_places c ON c.idplace = b.idplace        
	WHERE c.idplace = pidplace ORDER BY a.desadress;

END