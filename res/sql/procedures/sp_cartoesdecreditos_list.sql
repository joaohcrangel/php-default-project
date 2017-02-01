CREATE PROCEDURE sp_cartoesdecreditos_list()
BEGIN
	
	SELECT * FROM tb_cartoesdecreditos
    INNER JOIN tb_pessoas USING(idpessoa);

END