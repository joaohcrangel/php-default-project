CREATE PROCEDURE sp_ordersstatus_get(
pidstatus INT
)
BEGIN
	
	SELECT * FROM tb_ordersstatus WHERE idstatus = pidstatus;

END