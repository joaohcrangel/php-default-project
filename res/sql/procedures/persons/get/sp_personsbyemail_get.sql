CREATE PROCEDURE sp_personsbyemail_get(
pdesemail VARCHAR(256)
)
BEGIN

	SELECT a.* FROM tb_persons a
		INNER JOIN tb_contacts b ON a.idperson = b.idperson
	WHERE b.descontact = pdesemail;

END