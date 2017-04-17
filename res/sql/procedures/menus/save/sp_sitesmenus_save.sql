CREATE PROCEDURE sp_sitesmenus_save (
pidmenufather INT,
pidmenu INT,
pdesicon VARCHAR(64),
pdeshref VARCHAR(64),
pnrorder INT,
pdesmenu VARCHAR(128)
)
BEGIN

    IF pidmenufather = 0 THEN
        SET pidmenufather = NULL;
    END IF;

    IF pidmenu = 0 THEN
    
        INSERT INTO tb_sitesmenus (idmenufather, desicon, deshref, nrorder, desmenu)
        VALUES(pidmenufather, pdesicon, pdeshref, pnrorder, pdesmenu);
        
        SET pidmenu = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_sitesmenus

        SET 
            idmenufather = pidmenufather,
            desicon = pdesicon,
            deshref = pdeshref,
            nrorder = pnrorder,
            desmenu = pdesmenu
        WHERE idmenu = pidmenu;

    END IF;
    
    CALL sp_sitesmenustrigger_save(pidmenu, pidmenufather);

    CALL sp_sitesmenus_get(pidmenu);

END