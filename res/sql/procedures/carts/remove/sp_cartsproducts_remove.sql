CREATE PROCEDURE sp_cartsproducts_remove(
pidcart INT,
pidproduct INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_cartsproducts WHERE idcart = pidcart AND idproduct = pidproduct) THEN
    
		DELETE FROM tb_cartsproducts WHERE idcart = pidcart AND idproduct = pidproduct;
        
	END IF;

END