CREATE PROCEDURE sp_eventscalendars_remove(
pidcalendar INT
)
BEGIN

    DELETE FROM tb_eventscalendars 
    WHERE idcalendar = pidcalendar;

END;