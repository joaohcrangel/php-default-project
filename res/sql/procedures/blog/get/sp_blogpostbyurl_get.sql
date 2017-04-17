CREATE PROCEDURE sp_blogpostbyurl_get(
pdesurl VARCHAR(256)
)
BEGIN

	DECLARE pidpost INT;
    
    SELECT a.idpost INTO pidpost FROM tb_blogposts a
		INNER JOIN tb_urls b ON a.idurl = b.idurl
	WHERE b.desurl = pdesurl;
    
	IF pidpost > 0 THEN
    
		CALL sp_blogposts_get(pidpost);
        
	END IF;
    

END