CREATE PROCEDURE sp_pedidosstatus_get(
pidstatus INT
)
BEGIN
	
	SELECT * FROM tb_pedidosstatus WHERE idstatus = pidstatus;

END