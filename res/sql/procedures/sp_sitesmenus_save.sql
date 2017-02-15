CREATE PROCEDURE sp_sitesmenus_save (
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
    
        INSERT INTO tb_sitesmenus (idmenupai, desicone, deshref, nrordem, desmenu)
        VALUES(pidmenupai, pdesicone, pdeshref, pnrordem, pdesmenu);
        
        SET pidmenu = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_sitesmenus

        SET 
            idmenupai = pidmenupai,
            desicone = pdesicone,
            deshref = pdeshref,
            nrordem = pnrordem,
            desmenu = pdesmenu
        WHERE idmenu = pidmenu;

    END IF;
    
    CALL sp_sitesmenustrigger_save(pidmenu, pidmenupai);

    CALL sp_sitesmenus_get(pidmenu);

END