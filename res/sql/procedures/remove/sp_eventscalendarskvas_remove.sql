CREATE PROCEDURE sp_eventscalendarskvas_remove(
pidcalendar INT
)
BEGIN

    DELETE FROM tb_eventscalendarskvas 
    WHERE idcalendar = pidcalendar;

END;