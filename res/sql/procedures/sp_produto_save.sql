CREATE PROCEDURE sp_produto_save(
pidproduto INT,
pidprodutotipo INT,
pdesproduto VARCHAR(64),
pinremovido BIT(1)
)
BEGIN

	IF pidproduto = 0 THEN
    
		INSERT INTO tb_produtos(idprodutotipo, desproduto, inremovido)
        VALUES(pidprodutotipo, pdesproduto, pinremovido);
        
		SET pidproduto = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_produtos SET
			idprodutotipo = pidprodutotipo,
			desproduto = pdesproduto,
            inremovido = pinremovido
		WHERE idproduto = pidproduto;
        
	END IF;
    
    CALL sp_produto_get(pidproduto);

END