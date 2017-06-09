CREATE PROCEDURE sp_eventscalendarsdays_save(
pidday INT,
pidcalendar INT,
pdtstart DATETIME,
pdtend DATETIME,
pinevent BIT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidday = 0 THEN
    
        INSERT INTO tb_eventscalendarsdays (idcalendar, dtstart, dtend, inevent, dtregister)
        VALUES(pidcalendar, pdtstart, pdtend, pinevent, pdtregister);
        
        SET pidday = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventscalendarsdays        
        SET 
            idcalendar = pidcalendar,
            dtstart = pdtstart,
            dtend = pdtend,
            inevent = pinevent,
            dtregister = pdtregister        
        WHERE idday = pidday;

    END IF;

    CALL sp_eventscalendarsdays_get(pidday);

END;