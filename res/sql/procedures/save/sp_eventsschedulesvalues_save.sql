CREATE PROCEDURE sp_eventsschedulesvalues_save(
pidcalendar INT,
pidproperty INT,
pdesvalue VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidcalendar = 0 THEN
    
        INSERT INTO tb_eventsschedulesvalues (desvalue, dtregister)
        VALUES(pdesvalue, pdtregister);
        
        SET pidcalendar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsschedulesvalues        
        SET 
            desvalue = pdesvalue,
            dtregister = pdtregister        
        WHERE idcalendar = pidcalendar;

    END IF;

    CALL sp_eventsschedulesvalues_get(pidcalendar);

END;