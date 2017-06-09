CREATE PROCEDURE sp_eventscalendarskvas_get(
pidcalendar INT
)
BEGIN

    SELECT *    
    FROM tb_eventscalendarskvas    
    WHERE idcalendar = pidcalendar;

END;