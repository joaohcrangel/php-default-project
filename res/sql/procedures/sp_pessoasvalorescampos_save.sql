CREATE PROCEDURE sp_pessoasvalorescampos_save(
pidcampo INT,
pdescampo VARCHAR(128)
)
BEGIN

	IF pidcampo = 0 THEN
    
		INSERT INTO tb_pessoasvalorescampos(descampo)
        VALUES(pdescampo);
        
        SET pidcampo = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pessoasvalorescampos SET
			descampo = pdescampo
		WHERE idcampo = pidcampo;
        
	END IF;
    
    CALL sp_pessoasvalorescampos_get(pidcampo);

END