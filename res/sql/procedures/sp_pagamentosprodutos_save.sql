CREATE PROCEDURE sp_pagamentosprodutos_save(
pidpagamento INT,
pidproduto INT,
pnrqtd INT,
pvlpreco DEC(10,2),
pvltotal DEC(10,2)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_pagamentosprodutos WHERE idpagamento = pidpagamento AND idproduto = pidproduto) THEN
    
		UPDATE tb_pagamentosprodutos SET
			nrqtd = pnrqtd,
            vlpreco = pvlpreco,
            vltotal = pvltotal
		WHERE idpagamento = pidpagamento AND idproduto = pidproduto;
        
	ELSE
    
		INSERT INTO tb_pagamentosprodutos(idpagamento, idproduto, nrqtd, vlpreco, vltotal)
        VALUES(pidpagamento, pidproduto, pnrqtd, pvlpreco, pvltotal);
        
	END IF;
    
    CALL sp_pagamentosprodutos_get(pidpagamento, pidproduto);
    
END