CREATE PROCEDURE sp_coordenadas_remove(
pidcoordenada INT
)
BEGIN

    DELETE FROM tb_coordenadas 
    WHERE idcoordenada = pidcoordenada;

END