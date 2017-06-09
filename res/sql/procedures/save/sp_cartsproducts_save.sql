CREATE PROCEDURE `sp_cartsproducts_save`(
pidcart INT,
pidproduct INT
)
BEGIN
	
	INSERT INTO tb_cartsproducts (idcart, idproduct, idprice) 
    SELECT pidcart, pidproduct, idprice FROM tb_productsdata WHERE idproduct = pidproduct;
    
END