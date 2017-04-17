CREATE PROCEDURE sp_carrinhosprodutos_remove(
pidcarrinho INT,
pidproduto INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_carrinhosprodutos WHERE idcarrinho = pidcarrinho AND idproduto = pidproduto) THEN
    
		DELETE FROM tb_carrinhosprodutos WHERE idcarrinho = pidcarrinho AND idproduto = pidproduto;
        
	END IF;

END