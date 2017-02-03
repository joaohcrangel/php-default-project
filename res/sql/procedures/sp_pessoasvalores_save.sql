CREATE PROCEDURE sp_pessoasvalores_save(
pidpessoavalor INT,
pidpessoa INT,
pidcampo INT,
pdesvalor VARCHAR(128)
)
BEGIN

	IF pidpessoavalor = 0 THEN
    
		INSERT INTO tb_pessoasvalores(idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, pidcampo, pdesvalor);
        
        SET pidpessoavalor = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pessoasvalores SET
			idpessoa = pidpessoa,
            idcampo = pidcampo,
            desvalor = pdesvalor
		WHERE idpessoavalor = pidpessoavalor;
        
	END IF;
    
    CALL sp_pessoasvalores_get(pidpessoavalor);

END