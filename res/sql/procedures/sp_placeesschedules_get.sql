CREATE PROCEDURE sp_placeesschedules_get(
pidschedule INT
)
BEGIN

    SELECT *    
    FROM tb_placeesschedules    
    WHERE idschedule = pidschedule;

END