CREATE PROCEDURE sp_placestypes_save(
pidplacetype INT,
pdesplacetype VARCHAR(128)
)
BEGIN

	IF pidplacetype = 0 THEN
    
		INSERT INTO tb_placestypes(desplacetype)
			VALUES(pdesplacetype);
		SET pidplacetype = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_placestypes SET
			desplacetype = pdesplacetype
		WHERE idplacetype = pidplacetype;
        
	END IF;
    
    CALL sp_placestypes_get(pidplacetype);

END