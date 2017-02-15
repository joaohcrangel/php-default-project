CREATE PROCEDURE sp_pedidosrecibos_save(
pidpedido INT,
pdesautenticacao VARCHAR(256)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pedidosrecibos WHERE idpedido = pidpedido) THEN
    
		UPDATE tb_pedidosrecibos SET
			desautenticacao = pdesautenticacao
		WHERE idpedido = pidpedido;
        
	ELSE
    
		INSERT INTO tb_pedidosrecibos(idpedido, desautenticacao)
        VALUES(pidpedido, pdesautenticacao);
        
	END IF;
    
    CALL sp_pedidosrecibos_get(pidpedido);
    
END