CREATE PROCEDURE sp_carrinhosprodutos_get(
pidcarrinho INT,
pidproduto INT
)
BEGIN
	
	SELECT a.idcarrinho, a.dessession, a.vltotal, b.idproduto, b.desproduto, c.inremovido, d.idpessoa, d.despessoa
	FROM tb_carrinhosprodutos c
        INNER JOIN tb_carrinhos a ON a.idcarrinho = c.idcarrinho
        INNER JOIN tb_produtos b ON b.idproduto = c.idproduto
        INNER JOIN tb_pessoas d ON a.idpessoa = d.idpessoa
	WHERE c.idcarrinho = pidcarrinho AND c.idproduto = pidproduto AND b.inremovido = 0;

END