CREATE PROCEDURE sp_ordersproducts_remove(
pidorder INT,
pidproduct INT
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_ordersproducts WHERE idorder = pidorder AND idproduct = pidproduct) THEN
    
		DELETE FROM tb_ordersproducts WHERE idorder = pidorder AND idproduct = pidproduct;
        
	END IF;
    
END