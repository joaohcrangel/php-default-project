CREATE PROCEDURE sp_requestsreceipts_remove(
pidrequest INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_requestsreceipts WHERE idrequest = pidrequest) THEN
    
		DELETE FROM tb_requestsreceipts WHERE idrequest = pidrequest;
        
	END IF;
    
END