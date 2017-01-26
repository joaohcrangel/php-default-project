CREATE PROCEDURE sp_pagamentosrecibos_save(
pidpagamento INT,
pdesautenticacao VARCHAR(256)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pagamentosrecibos WHERE idpagamento = pidpagamento) THEN
    
		UPDATE tb_pagamentosrecibos SET
			desautenticacao = pdesautenticacao
		WHERE idpagamento = pidpagamento;
        
	ELSE
    
		INSERT INTO tb_pagamentosrecibos(idpagamento, desautenticacao)
        VALUES(pidpagamento, pdesautenticacao);
        
	END IF;
    
    CALL sp_pagamentosrecibos_get(pidpagamento);
    
END