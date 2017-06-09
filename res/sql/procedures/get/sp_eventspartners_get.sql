CREATE PROCEDURE sp_eventspartners_get(
pidcalendar INT
)
BEGIN

    SELECT *    
    FROM tb_eventspartners    
    WHERE idcalendar = pidcalendar;

END;