CREATE PROCEDURE sp_pagamentos_remove(
pidpagamento INT
)
BEGIN
	
	DELETE FROM tb_pagamentos WHERE idpagamento = pidpagamento;
    
END