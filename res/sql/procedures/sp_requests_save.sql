CREATE PROCEDURE sp_requests_save(
pidrequest INT,
pidperson INT,
pidformrequest INT,
pidstatus INT,
pdessession VARCHAR(128),
pvltotal DEC(10,2),
pnrplots INT
)
BEGIN
	
	IF pidrequest = 0 THEN
    
		INSERT INTO tb_requests(idperson, idformrequest, idstatus, dessession, vltotal, nrplots)
        VALUES(pidperson, pidformrequest, pidstatus, pdessession, pvltotal, pnrplots);
        
        SET pidpedido = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_requests SET
			idperson = pidperson,
            idformrequest = pidformrequest,
            idstatus = pidstatus,
            dessession = pdessession,
            vltotal = pvltotal,
           	nrplots = pnrplots
		WHERE idrequest = pidrequest;
        
	END IF;
    
    CALL sp_requests_get(pidrequest);
    
END