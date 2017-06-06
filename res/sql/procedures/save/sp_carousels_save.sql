CREATE PROCEDURE sp_carousels_save(
pidcarousel INT,
pdescarousel VARCHAR(64),
pnrspeed INT,
pnrautoplay INT,
pdesmode ENUM('horizontal', 'vertical'),
pinloop TINYINT(1),
pnritems INT
)
BEGIN

    IF pidcarousel = 0 THEN
    
        INSERT INTO tb_carousels (descarousel, nrspeed, nrautoplay, desmode, inloop, nritems)
        VALUES(pdescarousel, pnrspeed, pnrautoplay, pdesmode, pinloop, pnritems);
        
        SET pidcarousel = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carousels        
        SET 
            descarousel = pdescarousel,
            nrspeed = pnrspeed,
            nrautoplay = pnrautoplay,
            desmode = pdesmode,
            inloop = pinloop,            
            nritems = pnritems
        WHERE idcarousel = pidcarousel;

    END IF;

    CALL sp_carousels_get(pidcarousel);

END