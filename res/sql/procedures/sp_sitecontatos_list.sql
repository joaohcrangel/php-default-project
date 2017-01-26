CREATE PROCEDURE sp_sitecontatos_list()
BEGIN
	
	SELECT * FROM tb_sitecontatos INNER JOIN tb_pessoas USING(idpessoa);
    
END