CREATE PROCEDURE sp_pagamentosprodutos_list()
BEGIN
	
	SELECT * FROM tb_pagamentosprodutos a
    INNER JOIN tb_pagamentos b ON a.idpagamento = b.idpagamento
    INNER JOIN tb_produtos c ON c.idproduto = a.idproduto;
    
END