CREATE PROCEDURE sp_eventspartners_save(
pidcalendar INT,
pidperson INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidcalendar = 0 THEN
    
        INSERT INTO tb_eventspartners (dtregister)
        VALUES(pdtregister);
        
        SET pidcalendar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventspartners        
        SET 
            dtregister = pdtregister        
        WHERE idcalendar = pidcalendar;

    END IF;

    CALL sp_eventspartners_get(pidcalendar);

END;