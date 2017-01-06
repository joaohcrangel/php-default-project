CREATE PROCEDURE sp_pagamentos_list()
BEGIN
	
	SELECT * FROM tb_pagamentos a
		INNER JOIN tb_pessoas b ON a.idpessoa = b.idpessoa
        INNER JOIN tb_formaspagamentos c ON a.idformapagamento = c.idformapagamento
        INNER JOIN tb_pagamentosstatus d ON a.idstatus = d.idstatus;
    
END