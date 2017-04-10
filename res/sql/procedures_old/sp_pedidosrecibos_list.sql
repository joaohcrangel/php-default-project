CREATE PROCEDURE sp_requestsreceipts_list()
BEGIN
	
	SELECT * FROM tb_requestsreceipts INNER JOIN tb_requests USING(idrequest);
    
END