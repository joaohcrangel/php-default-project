CREATE PROCEDURE sp_produtosprecos_save(
pidpreco INT,
pidproduto INT,
pdtinicio DATETIME,
pdttermino DATETIME,
pvlpreco DEC(10,2)
)
BEGIN
	
	IF pidpreco = 0 THEN
    
		INSERT INTO tb_produtosprecos(idproduto, dtinicio, dttermino, vlpreco)
        VALUES(pidproduto, pdtinicio, pdttermino, pvlpreco);
        
        SET pidpreco = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_produtosprecos SET
			idproduto = pidproduto,
            dtinicio = pdtinicio,
            dttermino = pdttermino,
            vlpreco = pvlpreco
		WHERE idpreco = pidpreco;
        
	END IF;
    
    CALL sp_produtosprecos_get(pidpreco);
    
END