CREATE PROCEDURE sp_projectsstatus_save(
pidstatus INT,
pdesstatus VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF pidstatus = 0 THEN
    
        INSERT INTO tb_projectsstatus (desstatus, dtregister)
        VALUES(pdesstatus, pdtregister);
        
        SET pidstatus = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectsstatus        
        SET 
            desstatus = pdesstatus,
            dtregister = pdtregister        
        WHERE idstatus = pidstatus;

    END IF;

    CALL sp_projectsstatus_get(pidstatus);

END;