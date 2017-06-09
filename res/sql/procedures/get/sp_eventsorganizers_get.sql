CREATE PROCEDURE sp_eventsorganizers_get(
pidorganizer INT
)
BEGIN

    SELECT *    
    FROM tb_eventsorganizers    
    WHERE idorganizer = pidorganizer;

END;