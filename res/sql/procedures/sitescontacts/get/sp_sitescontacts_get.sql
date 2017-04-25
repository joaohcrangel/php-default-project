CREATE PROCEDURE sp_sitescontacts_get(
pidsitecontact INT
)
BEGIN
	
	SELECT * FROM tb_sitescontacts a
	INNER JOIN tb_persons b USING(idperson)
	INNER JOIN tb_users c ON b.idperson = c.idperson
	WHERE a.idsitecontact = pidsitecontact;
    
END