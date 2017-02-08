CREATE PROCEDURE sp_produtos_list()
BEGIN

	SELECT * FROM tb_produtos a INNER JOIN tb_produtostipos USING(idprodutotipo)
	WHERE a.inremovido = 0;

END