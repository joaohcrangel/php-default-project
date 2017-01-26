CREATE PROCEDURE sp_produto_remove(
pidproduto INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_produtosprecos WHERE idproduto = pidproduto) THEN
    
		DELETE FROM tb_produtosprecos WHERE idproduto = pidproduto;
        
	END IF;

	DELETE FROM tb_produtosdados WHERE idproduto = pidproduto;

	DELETE FROM tb_produtos WHERE idproduto = pidproduto;

END