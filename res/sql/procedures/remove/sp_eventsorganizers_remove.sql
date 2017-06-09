CREATE PROCEDURE sp_eventsorganizers_remove(
pidorganizer INT
)
BEGIN

    DELETE FROM tb_eventsorganizers 
    WHERE idorganizer = pidorganizer;

END;