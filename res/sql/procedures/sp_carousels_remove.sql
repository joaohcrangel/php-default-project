CREATE PROCEDURE sp_carousels_remove(
pidcarousel INT
)
BEGIN

    DELETE FROM tb_carousels 
    WHERE idcarousel = pidcarousel;

END