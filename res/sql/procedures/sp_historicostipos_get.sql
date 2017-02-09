CREATE PROCEDURE sp_historicostipos_get(
pidhistoricotipo INT
)
BEGIN

    SELECT *    
    FROM tb_historicostipos    
    WHERE idhistoricotipo = pidhistoricotipo;

END