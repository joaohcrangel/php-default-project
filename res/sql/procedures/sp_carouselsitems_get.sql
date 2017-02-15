CREATE PROCEDURE sp_carouselsitems_get(
piditem INT
)
BEGIN

    SELECT *    
    FROM tb_carouselsitems    
    WHERE iditem = piditem;

END