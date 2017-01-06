CREATE PROCEDURE sp_pagamentosstatus_remove(
pidstatus INT
)
BEGIN
	
	DELETE FROM tb_pagamentosstatus WHERE idstatus = pidstatus;

END