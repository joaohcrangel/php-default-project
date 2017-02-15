CREATE PROCEDURE sp_pedidos_save(
pidpedido INT,
pidpessoa INT,
pidformapedido INT,
pidstatus INT,
pdessession VARCHAR(128),
pvltotal DEC(10,2),
pnrparcelas INT
)
BEGIN
	
	IF pidpedido = 0 THEN
    
		INSERT INTO tb_pedidos(idpessoa, idformapedido, idstatus, dessession, vltotal, nrparcelas)
        VALUES(pidpessoa, pidformapedido, pidstatus, pdessession, pvltotal, pnrparcelas);
        
        SET pidpedido = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pedidos SET
			idpessoa = pidpessoa,
            idformapedido = pidformapedido,
            idstatus = pidstatus,
            dessession = pdessession,
            vltotal = pvltotal,
            nrparcelas = pnrparcelas
		WHERE idpedido = pidpedido;
        
	END IF;
    
    CALL sp_pedidos_get(pidpedido);
    
END