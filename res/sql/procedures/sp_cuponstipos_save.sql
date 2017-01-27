CREATE PROCEDURE sp_cuponstipos_save(
pidcupomtipo INT,
pdescupomtipo VARCHAR(128)
)
BEGIN

    IF pidcupomtipo = 0 THEN
    
		INSERT INTO tb_cuponstipos(descupomtipo)
        VALUES(pdescupomtipo);
        
		SET pidcupomtipo = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_cuponstipos SET
			descupomtipo = pdescupomtipo
		WHERE idcupomtipo = pidcupomtipo;
        
	END IF;
    
    CALL sp_cuponstipos_get(pidcupomtipo);

END