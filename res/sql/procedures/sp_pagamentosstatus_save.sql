CREATE PROCEDURE sp_pagamentosstatus_save(
pidstatus INT,
pdesstatus VARCHAR(128)
)
BEGIN
	
	IF pidstatus = 0 THEN
    
		INSERT INTO tb_pagamentosstatus(desstatus) VALUES(pdesstatus);
        
        SET pidstatus = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_pagamentosstatus SET
			desstatus = pdesstatus
		WHERE idstatus = pidstatus;
        
	END IF;
    
    CALL sp_pagamentosstatus_get(pidstatus);

END