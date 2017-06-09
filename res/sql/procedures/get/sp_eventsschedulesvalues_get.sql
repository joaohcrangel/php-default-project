CREATE PROCEDURE sp_eventsschedulesvalues_get(
pidcalendar INT
)
BEGIN

    SELECT *    
    FROM tb_eventsschedulesvalues    
    WHERE idcalendar = pidcalendar;

END;