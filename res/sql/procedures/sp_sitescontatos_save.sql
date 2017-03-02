CREATE PROCEDURE sp_sitescontatos_save(
pidsitecontato INT,
pidpessoa INT,
pdesmensagem VARCHAR(128),
pinlido BIT,
pidpessoaresposta INT
)
BEGIN
	
	IF pidsitecontato = 0 THEN
    
		INSERT INTO tb_sitescontatos(idpessoa, desmensagem, inlido, idpessoaresposta)
        VALUES(pidpessoa, pdesmensagem, pinlido, pidpessoaresposta);
        
        SET pidsitecontato = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_sitescontatos SET
			idpessoa = pidpessoa,
            desmensagem = pdesmensagem,
            inlido = pinlido,
            idpessoaresposta = pidpessoaresposta
		WHERE idsitecontato = pidsitecontato;
        
	END IF;
    
    CALL sp_sitescontatos_get(pidsitecontato);
    
END