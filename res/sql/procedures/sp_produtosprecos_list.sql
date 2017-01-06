CREATE PROCEDURE sp_produtosprecos_list()
BEGIN
	
	SELECT * FROM tb_produtosprecos INNER JOIN tb_produtos USING(idproduto);
    
END