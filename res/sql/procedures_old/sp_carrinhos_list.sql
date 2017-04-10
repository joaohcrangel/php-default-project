CREATE PROCEDURE sp_carrinhos_list ()
BEGIN
	
	SELECT * FROM tb_carrinhos
	INNER JOIN tb_pessoas USING(idpessoa);

END