CREATE PROCEDURE sp_ordersstatus_save(
pidstatus INT,
pdesstatus VARCHAR(128)
)
BEGIN
	
	IF pidstatus = 0 THEN
    
		INSERT INTO tb_ordersstatus(desstatus) VALUES(pdesstatus);
        
        SET pidstatus = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_ordersstatus SET
			desstatus = pdesstatus
		WHERE idstatus = pidstatus;
        
	END IF;
    
    CALL sp_ordersstatus_get(pidstatus);

END