CREATE PROCEDURE sp_placeestypes_save(
idplacetype INT,
pdesplacetype VARCHAR(128)
)
BEGIN

	IF pidplacetype = 0 THEN
    
		INSERT INTO tb_placeestypes(desplacetype)
			VALUES(pdesplacetype);
		SET pidplacetype = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_placeestypes SET
			desplacetype = pdesplacetype
		WHERE idplacetype = pidplacetype;
        
	END IF;
    
    CALL sp_placeestypes_get(pidplacetype);

END