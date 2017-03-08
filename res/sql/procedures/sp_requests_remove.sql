CREATE PROCEDURE sp_requests_remove(
pidrequest INT
)
BEGIN
	
	DELETE FROM tb_requests WHERE idrequest = pidrequest;
    
END