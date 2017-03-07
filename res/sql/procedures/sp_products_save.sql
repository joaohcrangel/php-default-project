CREATE PROCEDURE sp_products_save(
pidproduct INT,
pidproducttype INT,
pdesproduct VARCHAR(64),
pinremoved BIT,
pvlprice DECIMAL(10,2)
)
BEGIN
	
	DECLARE pvlpricecurrent DECIMAL(10,2);
    
	IF pidproduct = 0 THEN
    
		INSERT INTO tb_products(idproducttype, desproduct, inremoved)
        VALUES(pidproducttype, pdesproduct, pinremoved);
        
		SET pidproduct = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_products SET
			idproducttype = pidproducttype,
			desproduct = pdesproduct,
            inremoved = pinremoved
		WHERE idproduct = pidproduct;
        
	END IF;
    
    IF pvlprice > 0 THEN
		
		SELECT CASE WHEN vlprice IS NULL THEN 0 ELSE vlprice END INTO pvlpricecurrent
        FROM tb_productsdados
        WHERE idproduct = pidproduct;
        
        IF pvlpricecurrent <> pvlprice THEN
        
			UPDATE tb_productsprices
			SET dtend = NOW()
			WHERE
				idproduct = pidproduct
				AND
				(
					NOW() BETWEEN dtstart AND dtend
					OR
					(
						dtstart <= NOW() AND dtend IS NULL
					)
				);
				
			INSERT INTO tb_productsprices (idproduct, dtstart, dtend, vlprice)
			VALUES(pidproduct, NOW(), NULL, pvlprice);
            
		END IF;
    
    END IF;
    
    CALL sp_products_get(pidproduct);

END