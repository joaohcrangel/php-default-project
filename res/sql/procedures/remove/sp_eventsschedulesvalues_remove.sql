CREATE PROCEDURE sp_eventsschedulesvalues_remove(
pidcalendar INT
)
BEGIN

    DELETE FROM tb_eventsschedulesvalues 
    WHERE idcalendar = pidcalendar;

END;