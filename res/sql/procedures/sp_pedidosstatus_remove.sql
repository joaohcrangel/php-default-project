CREATE PROCEDURE sp_pedidosstatus_remove(
pidstatus INT
)
BEGIN
	
	DELETE FROM tb_pedidosstatus WHERE idstatus = pidstatus;

END