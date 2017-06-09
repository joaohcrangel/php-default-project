CREATE PROCEDURE sp_events_save(
pidevent INT,
pdesevent VARCHAR(64),
pidfrequency INT,
pnrfrequency INT,
pidorganizer INT
)
BEGIN

    IF pidevent = 0 THEN
    
        INSERT INTO tb_events (desevent, idfrequency, nrfrequency, idorganizer)
        VALUES(pdesevent, pidfrequency, pnrfrequency, pidorganizer);
        
        SET pidevent = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_events        
        SET 
            desevent = pdesevent,
            idfrequency = pidfrequency,
            nrfrequency = pnrfrequency,
            idorganizer = pidorganizer      
        WHERE idevent = pidevent;

    END IF;

    CALL sp_events_get(pidevent);

END;