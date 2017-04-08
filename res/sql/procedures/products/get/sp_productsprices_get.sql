CREATE PROCEDURE sp_productsprices_get(
pidprice INT
)
BEGIN
	
	SELECT * FROM tb_productsprices a
		INNER JOIN tb_products USING(idproduct)
	WHERE a.idprice = pidprice;
    
END