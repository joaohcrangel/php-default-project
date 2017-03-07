CREATE PROCEDURE sp_sitescontatos_list()
BEGIN
	
	SELECT *, CONCAT(SUBSTRING_INDEX(desmensagem, ' ', 5), '...') AS desmensagemabreviada 
	FROM tb_sitescontatos 
	INNER JOIN tb_pessoas USING(idpessoa);
    
END