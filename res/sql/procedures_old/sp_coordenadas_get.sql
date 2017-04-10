CREATE PROCEDURE sp_coordenadas_get(
pidcoordenada INT
)
BEGIN

    SELECT *    
    FROM tb_coordenadas    
    WHERE idcoordenada = pidcoordenada;

END