CREATE PROCEDURE sp_userslogin_get(
pdesuser VARCHAR(128)
)
BEGIN
	
	DECLARE piduser INT;

    SELECT 
    iduser INTO piduser    
    FROM tb_users
    WHERE 
		desuser = pdesuser;
	
	IF piduser > 0 THEN
    
		CALL sp_users_get(piduser);
        
	END IF;

END