CREATE PROCEDURE sp_pagamentosprodutos_remove(
pidpagamento INT,
pidproduto INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pagamentosprodutos WHERE idpagamento = pidpagamento AND idproduto = pidproduto) THEN
    
		DELETE FROM tb_pagamentosprodutos WHERE idpagamento = pidpagamento AND idproduto = pidproduto;
        
	END IF;
    
END