CREATE PROCEDURE sp_events_get(
pidevent INT
)
BEGIN

    SELECT *    
    FROM tb_events    
    WHERE idevent = pidevent;

END;