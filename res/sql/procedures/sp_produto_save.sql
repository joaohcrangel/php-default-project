CREATE PROCEDURE sp_produto_save(
pidproduto INT,
pidprodutotipo INT,
pdesproduto VARCHAR(64)
)
BEGIN

	IF pidproduto = 0 THEN
    
		INSERT INTO tb_produtos(idprodutotipo, desproduto)
        VALUES(pidprodutotipo, pdesproduto);
        
		SET pidproduto = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_produtos SET
			idprodutotipo = pidprodutotipo,
			desproduto = pdesproduto
		WHERE idproduto = pidproduto;
        
	END IF;
    
    CALL sp_produto_get(pidproduto);

END