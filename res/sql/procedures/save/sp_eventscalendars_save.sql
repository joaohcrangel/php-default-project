CREATE PROCEDURE sp_eventscalendars_save(
pidcalendar INT,
pidevent INT,
pidplace INT,
pdtstart DATETIME,
pdtend DATETIME,
pdesurl VARCHAR(128)
)
BEGIN

    IF pidcalendar = 0 THEN
    
        INSERT INTO tb_eventscalendars (idevent, idplace, dtstart, dtend, desurl)
        VALUES(pidevent, pidplace, pdtstart, pdtend, pdesurl);
        
        SET pidcalendar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventscalendars        
        SET 
            idevent = pidevent,
            idplace = pidplace,
            dtstart = pdtstart,
            dtend = pdtend,
            desurl = pdesurl
        WHERE idcalendar = pidcalendar;

    END IF;

    CALL sp_eventscalendars_get(pidcalendar);

END;