CREATE PROCEDURE sp_pedidosstatus_save(
pidstatus INT,
pdesstatus VARCHAR(128)
)
BEGIN
	
	IF pidstatus = 0 THEN
    
		INSERT INTO tb_pedidosstatus(desstatus) VALUES(pdesstatus);
        
        SET pidstatus = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pedidosstatus SET
			desstatus = pdesstatus
		WHERE idstatus = pidstatus;
        
	END IF;
    
    CALL sp_pedidosstatus_get(pidstatus);

END