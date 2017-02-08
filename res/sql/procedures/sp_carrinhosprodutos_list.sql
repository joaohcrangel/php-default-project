CREATE PROCEDURE sp_carrinhosprodutos_list()
BEGIN
	
	SELECT a.idcarrinho, a.dessession, a.vltotal, b.idproduto, b.desproduto, c.inremovido, d.idpessoa, d.despessoa
	FROM tb_carrinhosprodutos c
        INNER JOIN tb_carrinhos a ON a.idcarrinho = c.idcarrinho
        INNER JOIN tb_produtos b ON b.idproduto = c.idproduto
        INNER JOIN tb_pessoas d ON a.idpessoa = d.idpessoa
    WHERE b.inremovido = 0;

END