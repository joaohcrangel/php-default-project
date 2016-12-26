CREATE PROCEDURE sp_menus_save (
pidmenupai INT,
pidmenu INT,
pdesicone VARCHAR(64),
pdeshref VARCHAR(64),
pnrordem INT,
pdesmenu VARCHAR(128)
)
BEGIN

    IF pidmenupai = 0 THEN
        SET pidmenupai = NULL;
    END IF;

    IF pidmenu = 0 THEN
    
        INSERT INTO tb_menus (idmenupai, desicone, deshref, nrordem, desmenu)
        VALUES(pidmenupai, pdesicone, pdeshref, pnrordem, pdesmenu);
        
        SET pidmenu = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_menus

        SET 
            idmenupai = pidmenupai,
            desicone = pdesicone,
            deshref = pdeshref,
            nrordem = pnrordem,
            desmenu = pdesmenu
        WHERE idmenu = pidmenu;

    END IF;
    
    CALL sp_menustrigger_save(pidmenu, pidmenupai);

    CALL sp_menus_get(pidmenu);

END