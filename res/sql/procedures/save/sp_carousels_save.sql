CREATE PROCEDURE sp_carousels_save(
pidcarousel INT,
pdescarousel VARCHAR(64),
pinlooptinyint(1),
pinnavtinyint(1),
pincentertinyint(1),
pinautowidth tinyint(1),
pinvideo tinyint(1),
pinlazyload tinyint(1),
pindots tinyint(1),
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