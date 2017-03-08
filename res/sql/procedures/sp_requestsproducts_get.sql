CREATE PROCEDURE sp_requestsproducts_get(
pidrequest INT,
pidproduct INT
)
BEGIN
	
	SELECT * FROM tb_requestsproducts a
		INNER JOIN tb_requests b ON a.idrequest = b.idrequest
		INNER JOIN tb_products c ON c.idproduct = a.idproduct
	WHERE a.idrequest = pidrequest AND a.idproduct = pidproduct AND c.inremoved= 0;
    
END