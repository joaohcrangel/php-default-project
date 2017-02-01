CREATE PROCEDURE sp_pagamentosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT a.*, b.*, c.desformapagamento, d.* FROM tb_pagamentos a
		INNER JOIN tb_pessoas b USING(idpessoa)
        INNER JOIN tb_formaspagamentos c ON a.idformapagamento = c.idformapagamento
        INNER JOIN tb_pagamentosstatus d ON a.idstatus = d.idstatus
	WHERE a.idpessoa = pidpessoa;

END