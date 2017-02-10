CREATE PROCEDURE sp_coordenadas_save(
pidcoordenada INT,
pvllatitude DECIMAL(20,17),
pvllongitude DECIMAL(20,17),
pnrzoom TINYINT(4)
)
BEGIN

    IF pidcoordenada = 0 THEN
    
		INSERT INTO tb_coordenadas(vllatitude, vllongitude, nrzoom)
        VALUES(pvllatitude, pvllongitude, pnrzoom);
        
		SET pidcoordenada = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_coordenadas SET
			vllatitude = pvllatitude,
            vllongitude = pvllongitude,
            nrzoom = pnrzoom
		WHERE idcoordenada = pidcoordenada;
        
	END IF;
    
    CALL sp_coordenadas_get(pidcoordenada);

END