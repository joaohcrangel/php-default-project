CREATE PROCEDURE sp_events_save(
pidevent INT,
pdesevent VARCHAR(64),
pidfrequency INT,
pidorganizer INT
)
BEGIN

    IF pidevent = 0 THEN
    
        INSERT INTO tb_events (desevent, idfrequency, idorganizer)
        VALUES(pdesevent, pidfrequency, pidorganizer);
        
        SET pidevent = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_events        
        SET 
            desevent = pdesevent,
            idfrequency = pidfrequency,
            idorganizer = pidorganizer      
        WHERE idevent = pidevent;

    END IF;

    CALL sp_events_get(pidevent);

END;