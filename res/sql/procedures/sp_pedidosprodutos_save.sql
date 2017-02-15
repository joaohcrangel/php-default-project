CREATE PROCEDURE sp_pedidosprodutos_save(
pidpedido INT,
pidproduto INT,
pnrqtd INT,
pvlpreco DEC(10,2),
pvltotal DEC(10,2)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pedidosprodutos WHERE idpedido = pidpedido AND idproduto = pidproduto) THEN
    
		UPDATE tb_pedidosprodutos SET
			nrqtd = pnrqtd,
            vlpreco = pvlpreco,
            vltotal = pvltotal
		WHERE idpedido = pidpedido AND idproduto = pidproduto;
        
	ELSE
    
		INSERT INTO tb_pedidosprodutos(idpedido, idproduto, nrqtd, vlpreco, vltotal)
        VALUES(pidpedido, pidproduto, pnrqtd, pvlpreco, pvltotal);
        
	END IF;
    
    CALL sp_pedidosprodutos_get(pidpedido, pidproduto);
    
END