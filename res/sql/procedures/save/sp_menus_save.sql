CREATE PROCEDURE sp_menus_save(
pidmenu INT,
pidmenufather INT,
pdesmenu VARCHAR(128),
pdesicon VARCHAR(64),
pdeshref VARCHAR(64),
pnrorder INT,
pnrsubmenus INT
)
BEGIN
    
    IF pidmenufather = 0 THEN

        SET pidmenufather = NULL;

    END IF;

    IF pidmenu = 0 THEN
    
        INSERT INTO tb_menus (idmenufather, desmenu, desicon, deshref, nrorder, nrsubmenus)
        VALUES(pidmenufather, pdesmenu, pdesicon, pdeshref, pnrorder, pnrsubmenus);
        
        SET pidmenu = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_menus        
        SET 
            idmenufather = pidmenufather,
            desmenu = pdesmenu,
            desicon = pdesicon,
            deshref = pdeshref,
            nrorder = pnrorder,
            nrsubmenus = pnrsubmenus
        WHERE idmenu = pidmenu;

    END IF;

    CALL sp_menustrigger_save(pidmenu, pidmenufather);

    CALL sp_menus_get(pidmenu);

END