CREATE PROCEDURE sp_pagamentosrecibos_list()
BEGIN
	
	SELECT * FROM tb_pagamentosrecibos INNER JOIN tb_pagamentos USING(idpagamento);
    
END