CREATE PROCEDURE sp_sitescontatos_save(
pidsitecontato INT,
pidpessoa INT,
pdesmensagem VARCHAR(128),
pinlido BIT
)
BEGIN
	
	IF pidsitecontato = 0 THEN
    
		INSERT INTO tb_sitescontatos(idpessoa, desmensagem, inlido)
        VALUES(pidpessoa, pdesmensagem, pinlido);
        
        SET pidsitecontato = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_sitescontatos SET
			idpessoa = pidpessoa,
            desmensagem = pdesmensagem,
            inlido = pinlido
		WHERE idsitecontato = pidsitecontato;
        
	END IF;
    
    CALL sp_sitescontatos_get(pidsitecontato);
    
END