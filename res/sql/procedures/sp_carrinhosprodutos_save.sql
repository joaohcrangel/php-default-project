CREATE PROCEDURE sp_carrinhosprodutos_save(
pidcarrinho INT,
pidproduto INT,
pinremovido BIT,
pdtremovido DATETIME
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_carrinhosprodutos WHERE idcarrinho = pidcarrinho AND idproduto = pidproduto) THEN
    
		UPDATE tb_carrinhosprodutos SET
			inremovido = pinremovido,
            dtremovido = pdtremvido
		WHERE idcarrinho = pidcarrinho AND idproduto = pidproduto;
        
	ELSE
		
        INSERT INTO tb_carrinhosprodutos(idcarrinho, idproduto, inremovido, dtremovido)
        VALUES(pidcarrinho, pidproduto, pinremovido, pdtremovido);
        
	END IF;
    
    CALL sp_carrinhosprodutos_get(pidcarrinho, pidproduto);

END