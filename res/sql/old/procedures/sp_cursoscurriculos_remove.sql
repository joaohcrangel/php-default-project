CREATE PROCEDURE sp_cursoscurriculos_remove(
pidcurriculo INT
)
BEGIN

    DELETE FROM tb_cursoscurriculos 
    WHERE idcurriculo = pidcurriculo;

END