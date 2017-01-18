CREATE PROCEDURE sp_recibosfrompagamento_list(
pidpagamento INT
)
BEGIN

	SELECT * FROM tb_pagamentosrecibos
		INNER JOIN tb_pagamentos USING(idpagamento)
	WHERE idpagamento = pidpagamento;

END