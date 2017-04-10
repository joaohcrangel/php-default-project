CREATE PROCEDURE sp_creditcards_list()
BEGIN
	
	SELECT * FROM tb_creditcards
    INNER JOIN tb_persons USING(idperson);

END