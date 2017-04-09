CREATE PROCEDURE sp_sitescontacts_list()
BEGIN
	
	SELECT *, CONCAT(SUBSTRING_INDEX(desmessage, ' ', 5), '...') AS desmessageabbreviated 
	FROM tb_sitescontacts 
	INNER JOIN tb_pessoas USING(idperson);
    
END