CREATE PROCEDURE sp_events_save(
pidevent INT,
pdesevent VARCHAR(64),
pidfrequency INT,
pidorganizer INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidevent = 0 THEN
    
        INSERT INTO tb_events (desevent, idfrequency, idorganizer, dtregister)
        VALUES(pdesevent, pidfrequency, pidorganizer, pdtregister);
        
        SET pidevent = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_events        
        SET 
            desevent = pdesevent,
            idfrequency = pidfrequency,
            idorganizer = pidorganizer,
            dtregister = pdtregister        
        WHERE idevent = pidevent;

    END IF;

    CALL sp_events_get(pidevent);

END;