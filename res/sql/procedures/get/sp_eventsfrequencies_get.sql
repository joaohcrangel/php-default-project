CREATE PROCEDURE sp_eventsfrequencies_get(
pidfrequency INT
)
BEGIN

    SELECT *    
    FROM tb_eventsfrequencies    
    WHERE idfrequency = pidfrequency;

END;