CREATE PROCEDURE sp_requestsreceipts_save(
pidreceipt INT,
pdesauthentication VARCHAR(256)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_requestsreceipts WHERE idrequest = pidrequest) THEN
    
		UPDATE tb_requestsreceipts SET
			desauthentication = pdesauthentication
		WHERE idrequest = pidrequest;
        
	ELSE
    
		INSERT INTO tb_requestsreceipts(idrequest, desautenticacao)
        VALUES(pidrequest, pdesauthentication);
        
	END IF;
    
    CALL sp_requestsreceipts_get(pidrequest);
    
END