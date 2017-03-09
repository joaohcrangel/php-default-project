CREATE PROCEDURE sp_coordinates_get(
pidcoordinate INT
)
BEGIN

    SELECT *    
    FROM tb_coordinates   
    WHERE idcoordinate = pidcoordinate;

END