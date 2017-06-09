CREATE PROCEDURE sp_eventscalendars_get(
pidcalendar INT
)
BEGIN

    SELECT *    
    FROM tb_eventscalendars    
    WHERE idcalendar = pidcalendar;

END;