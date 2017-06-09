CREATE PROCEDURE sp_eventsfrequencies_remove(
pidfrequency INT
)
BEGIN

    DELETE FROM tb_eventsfrequencies 
    WHERE idfrequency = pidfrequency;

END;