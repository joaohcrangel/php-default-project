CREATE PROCEDURE sp_carrinhosfromproduto_list(
pidproduto INT
)
BEGIN

	SELECT * FROM tb_carrinhosprodutos a
		INNER JOIN tb_produtos b ON a.idproduto = b.idproduto
        INNER JOIN tb_carrinhos c ON a.idcarrinho = c.idcarrinho
	WHERE a.idproduto = pidproduto;

END