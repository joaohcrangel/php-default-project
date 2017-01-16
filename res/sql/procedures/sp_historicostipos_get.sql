CREATE PROCEDURE sp_hitoricostipos_get(
pidhistoricotipo INT
)
BEGIN

    SELECT *    
    FROM tb_hitoricostipos    
    WHERE idhistoricotipo = pidhistoricotipo;

END