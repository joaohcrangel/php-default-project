CREATE PROCEDURE sp_orders_save(
pidorder INT,
pidperson INT,
pidformrequest INT,
pidstatus INT,
pdessession VARCHAR(128),
pvltotal DEC(10,2),
pnrplots INT
)
BEGIN
	
	IF pidorder = 0 THEN
    
		INSERT INTO tb_requests(idperson, idformorder, idstatus, dessession, vltotal, nrplots)
        VALUES(pidperson, pidformorder, pidstatus, pdessession, pvltotal, pnrplots);
        
        SET pidorder = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_orders SET
			idperson = pidperson,
            idformorder = pidformorder,
            idstatus = pidstatus,
            dessession = pdessession,
            vltotal = pvltotal,
           	nrplots = pnrplots
		WHERE idorder = pidorder;
        
	END IF;
    
    CALL sp_orders_get(pidorder);
    
END