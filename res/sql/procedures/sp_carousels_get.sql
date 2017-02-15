CREATE PROCEDURE sp_carousels_get(
pidcarousel INT
)
BEGIN

    SELECT *    
    FROM tb_carousels    
    WHERE idcarousel = pidcarousel;

END