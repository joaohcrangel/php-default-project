CREATE PROCEDURE sp_events_remove(
pidevent INT
)
BEGIN

    DELETE FROM tb_events 
    WHERE idevent = pidevent;

END;