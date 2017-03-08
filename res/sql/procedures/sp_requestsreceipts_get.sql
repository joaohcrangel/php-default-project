CREATE PROCEDURE sp_requestsreceipts_get(
pidrequest INT
)
BEGIN
	
	SELECT * FROM tb_requestsreceipts a INNER JOIN tb_requests USING(idrequest)
    WHERE a.idrequest = pidrequest;
    
END