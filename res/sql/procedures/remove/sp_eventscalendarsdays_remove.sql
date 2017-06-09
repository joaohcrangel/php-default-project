CREATE PROCEDURE sp_eventscalendarsdays_remove(
pidday INT
)
BEGIN

    DELETE FROM tb_eventscalendarsdays 
    WHERE idday = pidday;

END;