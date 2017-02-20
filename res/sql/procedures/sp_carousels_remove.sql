CREATE PROCEDURE sp_carousels_remove(
pidcarousel INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_carouselsitems WHERE idcarousel = pidcarousel) THEN
    
		DELETE FROM tb_carouselsitems WHERE idcarousel = pidcarousel;
        
	END IF;

    DELETE FROM tb_carousels 
    WHERE idcarousel = pidcarousel;

END