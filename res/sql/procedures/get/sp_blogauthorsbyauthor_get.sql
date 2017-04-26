CREATE PROCEDURE sp_blogauthorsbyauthor_get(
pdesauthor VARCHAR(256)
)
BEGIN

	DECLARE pidauthor INT;
    
    SELECT idauthor INTO pidauthor FROM tb_blogauthors
		WHERE desauthor = pdesauthor;
        
	IF pidauthor > 0 THEN    
		CALL sp_blogauthors_get(pidauthor);        
	END IF;

END