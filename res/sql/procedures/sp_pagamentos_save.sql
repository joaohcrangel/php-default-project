CREATE PROCEDURE sp_pagamentos_save(
pidpagamento INT,
pidpessoa INT,
pidformapagamento INT,
pidstatus INT,
pdessession VARCHAR(128),
pvltotal DEC(10,2),
pnrparcelas INT
)
BEGIN
	
	IF pidpagamento = 0 THEN
    
		INSERT INTO tb_pagamentos(idpessoa, idformapagamento, idstatus, dessession, vltotal, nrparcelas)
        VALUES(pidpessoa, pidformapagamento, pidstatus, pdessession, pvltotal, pnrparcelas);
        
        SET pidpagamento = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pagamentos SET
			idpessoa = pidpessoa,
            idformapagamento = pidformapagamento,
            idstatus = pidstatus,
            dessession = pdessession,
            vltotal = pvltotal,
            nrparcelas = pnrparcelas
		WHERE idpagamento = pidpagamento;
        
	END IF;
    
    CALL sp_pagamentos_get(pidpagamento);
    
END