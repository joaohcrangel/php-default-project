CREATE PROCEDURE sp_carouselsitemstipos_remove(
pidtipo INT
)
BEGIN

    DELETE FROM tb_carouselsitemstipos 
    WHERE idtipo = pidtipo;

END