CREATE PROCEDURE sp_produto_save(
pidproduto INT,
pidprodutotipo INT,
pdesproduto VARCHAR(64),
pvlpreco DECIMAL(10,2)
)
BEGIN

	IF pidproduto = 0 THEN
    
		INSERT INTO tb_produtos(idprodutotipo, desproduto, vlpreco)
        VALUES(pidprodutotipo, pdesproduto, pvlpreco);
        
		SET pidproduto = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_produtos SET
			idprodutotipo = pidprodutotipo,
			desproduto = pdesproduto,
            vlpreco = pvlpreco
		WHERE idproduto = pidproduto;
        
	END IF;
    
    CALL sp_produto_get(pidproduto);

END