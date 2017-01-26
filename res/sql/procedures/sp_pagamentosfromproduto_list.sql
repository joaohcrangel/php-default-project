CREATE PROCEDURE sp_pagamentosfromproduto_list(
pidproduto INT
)
BEGIN

	SELECT * FROM tb_pagamentosprodutos a
		INNER JOIN tb_pagamentos b ON a.idpagamento = b.idpagamento
        INNER JOIN tb_produtos c ON a.idproduto = c.idproduto
	WHERE a.idproduto = pidproduto;

END