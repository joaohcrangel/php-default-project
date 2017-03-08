CREATE PROCEDURE sp_requestsproducts_list()
BEGIN
	
	SELECT * FROM tb_requestsproducts a
    INNER JOIN tb_requests b ON a.idrequest = b.idrequest
    INNER JOIN tb_products c ON c.idproduct = a.idproduct;
    
END