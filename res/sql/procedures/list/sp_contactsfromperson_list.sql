CREATE PROCEDURE sp_contactsfromperson_list(
pidperson INT
)
BEGIN

	SELECT * 
	FROM tb_contacts a
	INNER JOIN tb_contactssubtypes b ON a.idcontactsubtype = b.idcontactsubtype 
	INNER JOIN tb_contactstypes c ON c.idcontacttype = b.idcontacttype 
	WHERE idperson = pidperson 
	ORDER BY descontact;

END