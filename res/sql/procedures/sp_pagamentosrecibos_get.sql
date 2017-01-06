CREATE PROCEDURE sp_pagamentosrecibos_get(
pidpagamento INT
)
BEGIN
	
	SELECT * FROM tb_pagamentosrecibos a INNER JOIN tb_pagamentos USING(idpagamento)
    WHERE a.idpagamento = pidpagamento;
    
END