CREATE PROCEDURE sp_carousels_save(
pidcarousel INT,
pdescarousel VARCHAR(64),
pinloop BIT,
pinnav BIT,
pincenter BIT,
pinautowidth BIT,
pinvideo BIT,
pinlazyload BIT,
pindots BIT,
pnritems INT,
pnrstagepadding INT
)
BEGIN

    IF pidcarousel = 0 THEN
    
        INSERT INTO tb_carousels (descarousel, inloop, innav, incenter, inautowidth, invideo, inlazyload, indots, nritems, nrstagepadding)
        VALUES(pdescarousel, pinloop, pinnav, pincenter, pinautowidth, pinvideo, pinlazyload, pindots, pnritems, pnrstagepadding);
        
        SET pidcarousel = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carousels        
        SET 
            descarousel = pdescarousel,
            inloop = pinloop,
            innav = pinnav,
            incenter = pincenter,
            inautowidth = pinautowidth,
            invideo = pinvideo,
            inlazyload = pinlazyload,
            indots = pindots,
            nritems = pnritems,
            nrstagepadding = pnrstagepadding        
        WHERE idcarousel = pidcarousel;

    END IF;

    CALL sp_carousels_get(pidcarousel);

END