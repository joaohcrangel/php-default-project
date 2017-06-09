CREATE PROCEDURE sp_sitescontacts_save(
pidsitecontact INT,
pidsitecontactfather INT,
pidperson INT,
pdesmessage VARCHAR(128),
pinread TINYINT(1),
pidpersonanswer INT
)
BEGIN
	
	IF pidsitecontact = 0 THEN
    
		INSERT INTO tb_sitescontacts(idsitecontactfather, idperson, desmessage, inread,idpersonanswer)
        VALUES(pidsitecontactfather, pidperson, pdesmessage, pinread, pidpersonanswer);
        
        SET pidsitecontact = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_sitescontacts SET
			idsitecontactfather = pidsitecontactfather,
			idperson = pidperson,
            desmessage = pdesmessage,
            inread = pinread,
            idpersonanswer = pidpersonanswer
		WHERE idsitecontact = pidsitecontact;
        
	END IF;
    
    CALL sp_sitescontacts_get(pidsitecontact);
    
END