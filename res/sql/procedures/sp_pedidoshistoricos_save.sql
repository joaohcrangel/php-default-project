CREATE PROCEDURE sp_pedidoshistoricos_save(
pidhistorico INT,
pidpedido INT,
pidusuario INT
)
BEGIN

    IF pidhistorico = 0 THEN
    
		INSERT INTO tb_pedidoshistoricos(idpedido, idusuario)
        VALUES(pidpedido, pidusuario);
        
		SET pidhistorico = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pedidoshistoricos SET
        
			idpedido = pidpedido,
            idusuario = pidusuario
            
		WHERE idhistorico = pidhistorico;
        
	END IF;
    
    CALL sp_pedidoshistoricos_get(pidhistorico);

END