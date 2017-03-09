CREATE PROCEDURE sp_carouselsitems_save(
piditem INT,
pdesitem VARCHAR(45),
pdescontent TEXT,
pnrordem VARCHAR(45),
pidtype INT,
pidcarousel INT
)
BEGIN

    IF piditem = 0 THEN
    
        INSERT INTO tb_carouselsitems (desitem, descontent, nrordem, idtype, idcarousel)
        VALUES(pdesitem, pdescontent, pnrordem, pidtype, pidcarousel);
        
        SET piditem = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carouselsitems        
        SET 
            desitem = pdesitem,
            descontent = pdescontent,
            nrordem = pnrordem,
            idtype = pidtype,
            idcarousel = pidcarousel        
        WHERE iditem = piditem;

    END IF;

    CALL sp_carouselsitems_get(piditem);

END