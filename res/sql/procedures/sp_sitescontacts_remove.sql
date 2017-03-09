CREATE PROCEDURE sp_sitescontacts_remove(
pidsitecontact INT
)
BEGIN
	
	DELETE FROM tb_sitescontacts WHERE idsitecontact = pidsitecontact;
    
END