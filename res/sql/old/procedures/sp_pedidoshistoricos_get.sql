CREATE PROCEDURE sp_pedidoshistoricos_get(
pidhistorico INT
)
BEGIN

    SELECT *    
    FROM tb_pedidoshistoricos    
    WHERE idhistorico = pidhistorico;

END