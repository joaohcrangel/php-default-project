CREATE PROCEDURE sp_pedidoshistoricos_remove(
pidhistorico INT
)
BEGIN

    DELETE FROM tb_pedidoshistoricos 
    WHERE idhistorico = pidhistorico;

END