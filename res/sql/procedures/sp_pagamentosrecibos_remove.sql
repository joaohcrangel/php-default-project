CREATE PROCEDURE sp_pagamentosrecibos_remove(
pidpagamento INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pagamentosrecibos WHERE idpagamento = pidpagamento) THEN
    
		DELETE FROM tb_pagamentosrecibos WHERE idpagamento = pidpagamento;
        
	END IF;
    
END