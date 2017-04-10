CREATE PROCEDURE sp_ordersstatus_remove(
pidstatus INT
)
BEGIN
	
	DELETE FROM tb_ordersstatus WHERE idstatus = pidstatus;

END