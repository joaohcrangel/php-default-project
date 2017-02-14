CREATE PROCEDURE sp_sitesmenustrigger_save (
pidmenu INT,
pidmenupai INT
)
BEGIN
	
    DECLARE pnrsubmenus1 INT;
    DECLARE pnrsubmenus2 INT;
    
    SELECT COUNT(*) INTO pnrsubmenus1 
    FROM tb_sitesmenus 
    WHERE idmenupai = pidmenu;
    
    SELECT COUNT(*) INTO pnrsubmenus2 
    FROM tb_sitesmenus 
    WHERE idmenupai = pidmenupai;
    
    UPDATE tb_sitesmenus
    SET nrsubmenus = pnrsubmenus1
    WHERE idmenu = pidmenu;
    
    UPDATE tb_sitesmenus
    SET nrsubmenus = pnrsubmenus2
    WHERE idmenu = pidmenupai;
    
END