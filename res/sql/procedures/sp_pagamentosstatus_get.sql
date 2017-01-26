CREATE PROCEDURE sp_pagamentosstatus_get(
pidstatus INT
)
BEGIN
	
	SELECT * FROM tb_pagamentosstatus WHERE idstatus = pidstatus;

END