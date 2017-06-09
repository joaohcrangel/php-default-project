CREATE PROCEDURE sp_eventscalendarsfiles_get(
pidcalendar INT
)
BEGIN

    SELECT *    
    FROM tb_eventscalendarsfiles    
    WHERE idcalendar = pidcalendar;

END;