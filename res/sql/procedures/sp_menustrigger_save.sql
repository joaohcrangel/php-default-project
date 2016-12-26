CREATE PROCEDURE sp_menustrigger_save (
pidmenu INT,
pidmenupai INT
)
BEGIN
	
    DECLARE pnrsubmenus1 INT;
    DECLARE pnrsubmenus2 INT;
    
    SELECT COUNT(*) INTO pnrsubmenus1 
    FROM tb_menus 
    WHERE idmenupai = pidmenu;
    
    SELECT COUNT(*) INTO pnrsubmenus2 
    FROM tb_menus 
    WHERE idmenupai = pidmenupai;
    
    UPDATE tb_menus
    SET nrsubmenus = pnrsubmenus1
    WHERE idmenu = pidmenu;
    
    UPDATE tb_menus
    SET nrsubmenus = pnrsubmenus2
    WHERE idmenu = pidmenupai;
    
END