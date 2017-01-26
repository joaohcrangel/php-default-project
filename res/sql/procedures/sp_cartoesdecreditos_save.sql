CREATE PROCEDURE sp_cartoesdecreditos_save(
pidcartao INT,
pidpessoa INT,
pdesnome VARCHAR(64),
pdtvalidade DATE,
pnrcds VARCHAR(8),
pdesnumero CHAR(16)
)
BEGIN
	
	IF pidcartao = 0 THEN
    
		INSERT INTO tb_cartoesdecreditos(idpessoa, desnome, dtvalidade, nrcds, desnumero)
        VALUES(pidpessoa, pdesnome, pdtvalidade, pnrcds, pdesnumero);
        
		SET pidcartao = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_cartoesdecreditos SET        
			idpessoa = pidpessoa,
            desnome = pdesnome,
            dtvalidade = pdtvalidade,
            nrcds = pnrcds,
            desnumero = pdesnumero
		WHERE idcartao = pidcartao;
        
	END IF;
    
    CALL sp_cartoesdecreditos_get(pidcartao);

END