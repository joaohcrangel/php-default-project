CREATE PROCEDURE sp_carouselsitems_save(
piditem INT,
pdesitem VARCHAR(45),
pdesconteudo TEXT,
pnrordem VARCHAR(45),
pidtipo INT,
pidcarousel INT
)
BEGIN

    IF piditem = 0 THEN
    
        INSERT INTO tb_carouselsitems (desitem, desconteudo, nrordem, idtipo, idcarousel)
        VALUES(pdesitem, pdesconteudo, pnrordem, pidtipo, pidcarousel);
        
        SET piditem = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carouselsitems        
        SET 
            desitem = pdesitem,
            desconteudo = pdesconteudo,
            nrordem = pnrordem,
            idtipo = pidtipo,
            idcarousel = pidcarousel        
        WHERE iditem = piditem;

    END IF;

    CALL sp_carouselsitems_get(piditem);

END