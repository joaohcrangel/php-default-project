CREATE PROCEDURE sp_placeesschedules_list(
pidplace INT
)
BEGIN

    SELECT *
    FROM tb_placeesschedules
    WHERE idplace = pidplace
    ORDER BY nrday, hropen, hrclose;

END