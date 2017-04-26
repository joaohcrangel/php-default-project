CREATE PROCEDURE sp_productsprices_list()
BEGIN
	
	SELECT * FROM tb_productsprices INNER JOIN tb_products USING(idproduct);
    
END