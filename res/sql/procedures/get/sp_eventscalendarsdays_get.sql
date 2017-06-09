CREATE PROCEDURE sp_eventscalendarsdays_get(
pidday INT
)
BEGIN

    SELECT *    
    FROM tb_eventscalendarsdays    
    WHERE idday = pidday;

END;