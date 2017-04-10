CREATE PROCEDURE sp_cursoscurriculos_get(
pidcurriculo INT
)
BEGIN

    SELECT *
    FROM tb_cursoscurriculos
    WHERE idcurriculo = pidcurriculo;

END