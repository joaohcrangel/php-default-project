CREATE PROCEDURE sp_produtos_list()
BEGIN

	SELECT * FROM tb_produtos INNER JOIN tb_produtostipos USING(idprodutotipo);

END