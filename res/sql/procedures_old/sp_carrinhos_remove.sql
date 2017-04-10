CREATE PROCEDURE sp_carrinhos_remove(
pidcarrinho INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_carrinhosprodutos WHERE idcarrinho = pidcarrinho) THEN
    
		DELETE FROM tb_carrinhosprodutos WHERE idcarrinho = pidcarrinho;
        
	END IF;
    
    DELETE FROM tb_carrinhos WHERE idcarrinho = pidcarrinho;

END