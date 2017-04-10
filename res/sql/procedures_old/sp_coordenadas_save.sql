CREATE PROCEDURE sp_coordinates_save(
pidcoordinate INT,
pvllatitude DECIMAL(20,17),
pvllongitude DECIMAL(20,17),
pnrzoom TINYINT(4)
)
BEGIN

    IF pidcoordinate = 0 THEN
    
		INSERT INTO tb_coordinates(vllatitude, vllongitude, nrzoom)
        VALUES(pvllatitude, pvllongitude, pnrzoom);
        
		SET pidcoordinate = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_coordinates SET
			vllatitude = pvllatitude,
            vllongitude = pvllongitude,
            nrzoom = pnrzoom
		WHERE idcoordinate = pidcoordinate;
        
	END IF;
    
    CALL sp_coordinates_get(pidcoordinate);

END