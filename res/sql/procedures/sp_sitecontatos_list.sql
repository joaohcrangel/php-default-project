CREATE PROCEDURE sp_sitecontatos_list()
BEGIN
	
	SELECT *, CONCAT(SUBSTRING_INDEX(desmensagem, ' ', 5), '...') AS desmensagemabreviada FROM tb_sitecontatos INNER JOIN tb_pessoas USING(idpessoa);
    
END