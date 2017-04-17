CREATE PROCEDURE sp_produtosfromcarrinho_list(
pidcarrinho INT
)
BEGIN

	SELECT a.*, b.despessoa, c.dtremovido, d.idproduto, d.desproduto, d.desprodutotipo, d.vlpreco FROM tb_carrinhos a
		INNER JOIN tb_pessoas b ON a.idpessoa = b.idpessoa
        INNER JOIN tb_carrinhosprodutos c ON a.idcarrinho = c.idcarrinho
        INNER JOIN tb_produtosdados d ON c.idproduto = d.idproduto
	WHERE a.idcarrinho = pidcarrinho;

END