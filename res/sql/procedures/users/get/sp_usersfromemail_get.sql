CREATE PROCEDURE sp_usersfromemail_get(
pdesemail VARCHAR(64)
)
BEGIN
	
	DECLARE piduser INT;

    SELECT 
    iduser INTO piduser    
    FROM tb_users a
    INNER JOIN tb_contacts b USING(idperson)
    WHERE 
		b.descontact = pdesemail
        AND
        b.idcontacttype = 1;
	
	IF piduser > 0 THEN
    
		CALL sp_users_get(piduser);
        
	END IF;

END