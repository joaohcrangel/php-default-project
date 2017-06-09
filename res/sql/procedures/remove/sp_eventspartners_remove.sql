CREATE PROCEDURE sp_eventspartners_remove(
pidcalendar INT
)
BEGIN

    DELETE FROM tb_eventspartners 
    WHERE idcalendar = pidcalendar;

END;