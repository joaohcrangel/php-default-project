CREATE PROCEDURE sp_carouselsitems_remove(
piditem INT
)
BEGIN

    DELETE FROM tb_carouselsitems 
    WHERE iditem = piditem;

END