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
		b.descontact = pdesemail;
	
	IF piduser > 0 THEN
    
		CALL sp_users_get(piduser);
        
	END IF;

END