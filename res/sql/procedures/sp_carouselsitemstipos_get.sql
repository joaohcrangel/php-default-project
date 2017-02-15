CREATE PROCEDURE sp_carouselsitemstipos_get(
pidtipo INT
)
BEGIN

    SELECT *    
    FROM tb_carouselsitemstipos    
    WHERE idtipo = pidtipo;

END