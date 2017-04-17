CREATE PROCEDURE sp_placesschedules_list(
pidplace INT
)
BEGIN

    SELECT *
    FROM tb_placesschedules
    WHERE idplace = pidplace
    ORDER BY nrday, hropen, hrclose;

END