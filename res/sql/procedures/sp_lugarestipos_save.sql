CREATE PROCEDURE sp_lugarestipos_save(
pidlugartipo INT,
pdeslugartipo VARCHAR(128)
)
BEGIN

	IF pidlugartipo = 0 THEN
    
		INSERT INTO tb_lugarestipos(deslugartipo)
			VALUES(pdeslugartipo);
		SET pidlugartipo = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_lugarestipos SET
			deslugartipo = pdeslugartipo
		WHERE idlugartipo = pidlugartipo;
        
	END IF;
    
    CALL sp_lugarestipos_get(pidlugartipo);

END