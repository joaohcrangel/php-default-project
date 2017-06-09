CREATE PROCEDURE sp_carouselsitems_save(
piditem INT,
pdesitem VARCHAR(45),
pdescontent TEXT,
pnrorder VARCHAR(45),
pidtype INT,
pidcover INT,
pidcarousel INT
)
BEGIN

    IF piditem = 0 THEN
    
        INSERT INTO tb_carouselsitems (desitem, descontent, nrorder, idtype, idcover, idcarousel)
        VALUES(pdesitem, pdescontent, pnrorder, pidtype, pidcover, pidcarousel);
        
        SET piditem = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carouselsitems        
        SET 
            desitem = pdesitem,
            descontent = pdescontent,
            nrorder = pnrorder,
            idtype = pidtype,
            idcover = pidcover,
            idcarousel = pidcarousel        
        WHERE iditem = piditem;

    END IF;

    CALL sp_carouselsitems_get(piditem);

END