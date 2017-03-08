CREATE PROCEDURE sp_requestsproducts_remove(
pidrequest INT,
pidproduct INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_requestsproducts WHERE idrequest = pidrequest AND idproduct = pidproduct) THEN
    
		DELETE FROM tb_requestsproducts WHERE idrequest = pidrequest AND idproduct = pidproduct;
        
	END IF;
    
END