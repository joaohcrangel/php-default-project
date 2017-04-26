CREATE PROCEDURE sp_blogcategorybyurl_get(
pdesurl VARCHAR(256)
)
BEGIN

	DECLARE pidcategory INT;
    
    SELECT b.idcategory INTO pidcategory FROM tb_urls a
		INNER JOIN tb_blogcategories b ON a.idurl = b.idurl
	WHERE a.desurl = pdesurl;
    
    IF pidcategory > 0 THEN
    
		CALL sp_blogcategories_get(pidcategory);
        
	END IF;

END