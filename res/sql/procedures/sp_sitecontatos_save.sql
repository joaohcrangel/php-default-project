CREATE PROCEDURE sp_sitecontatos_save(
pidsitecontato INT,
pidpessoa INT,
pdesmensagem VARCHAR(128),
pinlido BIT
)
BEGIN
	
	IF pidsitecontato = 0 THEN
    
		INSERT INTO tb_sitecontatos(idpessoa, desmensagem, inlido)
        VALUES(pidpessoa, pdesmensagem, pinlido);
        
        SET pidsitecontato = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_sitecontatos SET
			idpessoa = pidpessoa,
            desmensagem = pdesmensagem,
            inlido = pinlido
		WHERE idsitecontato = pidsitecontato;
        
	END IF;
    
    CALL sp_sitecontatos_get(pidsitecontato);
    
END