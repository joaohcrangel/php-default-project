CREATE PROCEDURE sp_eventscalendarskvas_save(
pidcalendar INT,
pidmaterial INT,
pvlkva DECIMAL(10,2),
pdtregister TIMESTAMP
)
BEGIN

    IF pidcalendar = 0 THEN
    
        INSERT INTO tb_eventscalendarskvas (vlkva, dtregister)
        VALUES(pvlkva, pdtregister);
        
        SET pidcalendar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventscalendarskvas        
        SET 
            vlkva = pvlkva,
            dtregister = pdtregister        
        WHERE idcalendar = pidcalendar;

    END IF;

    CALL sp_eventscalendarskvas_get(pidcalendar);

END;