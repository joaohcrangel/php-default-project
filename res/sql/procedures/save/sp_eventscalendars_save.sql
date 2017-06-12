CREATE PROCEDURE sp_eventscalendars_save(
pidcalendar INT,
pidevent INT,
pidplace INT,
pidurl INT,
pdtstart DATETIME,
pdtend DATETIME
)
BEGIN

    IF pidcalendar = 0 THEN
    
        INSERT INTO tb_eventscalendars (idevent, idplace, idurl, dtstart, dtend)
        VALUES(pidevent, pidplace, pidurl, pdtstart, pdtend);
        
        SET pidcalendar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventscalendars        
        SET 
            idevent = pidevent,
            idplace = pidplace,
            idurl = pidurl,
            dtstart = pdtstart,
            dtend = pdtend
        WHERE idcalendar = pidcalendar;

    END IF;

    CALL sp_eventscalendars_get(pidcalendar);

END;