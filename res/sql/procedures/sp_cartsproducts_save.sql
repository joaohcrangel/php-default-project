CREATE PROCEDURE sp_cartsproducts_save(
pidcart INT,
pidproduct INT,
pinremoved BIT,
pdtremoved DATETIME
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_cartsproducts WHERE idcart = pidcart AND idproduct = pidproduct) THEN
    
		UPDATE tb_cartsproducts SET
			inremoved = pinremoved,
            dtremoved = pdtremvido
		WHERE idcart = pidcart AND idproduct = pidproduct;
        
	ELSE
		
        INSERT INTO tb_cartsproducts(idcart, idproduct, inremoved, dtremoved)
        VALUES(pidcart, pidproduct, pinremoved, pdtremoved);
        
	END IF;
    
    CALL sp_cartsproducts_get(pidcart, pidproduct);

END