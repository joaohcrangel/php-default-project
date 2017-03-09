CREATE PROCEDURE sp_placeesschedules_remove(
pidschedule INT
)
BEGIN

    DELETE FROM tb_placeesschedules 
    WHERE idschedule = pidschedule;

END