CREATE PROCEDURE sp_pedidosprodutos_remove(
pidpedido INT,
pidproduto INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pedidosprodutos WHERE idpedido = pidpedido AND idproduto = pidproduto) THEN
    
		DELETE FROM tb_pedidosprodutos WHERE idpedido = pidpedido AND idproduto = pidproduto;
        
	END IF;
    
END