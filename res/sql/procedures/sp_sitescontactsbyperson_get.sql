CREATE PROCEDURE sp_sitescontactsbyperson_get(
pdesemail VARCHAR(128)
)
BEGIN
    
    DECLARE pidperson INT;
        
	SELECT
    idperson INTO pidperson
    FROM tb_contacts
    WHERE
		descontact = pdesemail;
	
	IF pidperson > 0 THEN
    
		CALL sp_persons_get(pidperson);
        
	END IF;

END