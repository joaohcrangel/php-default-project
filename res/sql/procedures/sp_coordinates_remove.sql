CREATE PROCEDURE sp_coordinates_remove(
pidcoordinate INT
)
BEGIN

    DELETE FROM tb_coordinates 
    WHERE idcoordinate = pidcoordinate;

END