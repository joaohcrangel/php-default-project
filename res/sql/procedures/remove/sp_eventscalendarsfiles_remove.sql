CREATE PROCEDURE sp_eventscalendarsfiles_remove(
pidcalendar INT
)
BEGIN

    DELETE FROM tb_eventscalendarsfiles 
    WHERE idcalendar = pidcalendar;

END;