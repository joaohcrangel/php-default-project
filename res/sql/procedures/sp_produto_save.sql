CREATE PROCEDURE sp_produto_save(
pidproduto INT,
pidprodutotipo INT,
pdesproduto VARCHAR(64),
pinremovido BIT,
pvlpreco DECIMAL(10,2)
)
BEGIN
	
	DECLARE pvlprecoatual DECIMAL(10,2);
    
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
    
    IF pvlpreco > 0 THEN
		
		SELECT vlpreco INTO pvlprecoatual
        FROM tb_produtosdados
        WHERE idproduto = pidproduto;
        
        IF pvlprecoatual <> pvlpreco THEN
        
			UPDATE tb_produtosprecos
			SET dttermino = NOW()
			WHERE
				idproduto = pidproduto
				AND
				(
					NOW() BETWEEN dtinicio AND dttermino
					OR
					(
						dtinicio <= NOW() AND dttermino IS NULL
					)
				);
				
			INSERT INTO tb_produtosprecos (idproduto, dtinicio, dttermino, vlpreco)
			VALUES(pidproduto, NOW(), NULL, pvlpreco);
            
		END IF;
    
    END IF;
    
    CALL sp_produto_get(pidproduto);

END