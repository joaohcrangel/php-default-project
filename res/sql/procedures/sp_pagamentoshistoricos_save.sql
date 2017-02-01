CREATE PROCEDURE sp_pagamentoshistoricos_save(
pidhistorico INT,
pidpagamento INT,
pidusuario INT
)
BEGIN

    IF pidhistorico = 0 THEN
    
		INSERT INTO tb_pagamentoshistoricos(idpagamento, idusuario)
        VALUES(pidpagamento, pidusuario);
        
		SET pidhistorico = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pagamentoshistoricos SET
        
			idpagamento = pidpagamento,
            idusuario = pidusuario
            
		WHERE idhistorico = pidhistorico;
        
	END IF;
    
    CALL sp_pagamentoshistoricos_get(pidhistorico);

END