CREATE PROCEDURE sp_lugareshorarios_list(
pidlugar INT
)
BEGIN

    SELECT *
    FROM tb_lugareshorarios
    WHERE idlugar = pidlugar
    ORDER BY nrdia, hrabre, hrfecha;

END