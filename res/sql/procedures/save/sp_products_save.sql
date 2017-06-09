CREATE PROCEDURE sp_products_save(
pidproduct INT,
pidproducttype INT,
pdesproduct VARCHAR(64),
pinremoved TINYINT,
pidthumb INT,
pdescode VARCHAR(64),
pdesbarcode CHAR(13),
pdtregister TIMESTAMP
)
BEGIN

    IF pidproduct = 0 THEN
    
        INSERT INTO tb_products (idproducttype, desproduct, inremoved, idthumb, descode, desbarcode, dtregister)
        VALUES(pidproducttype, pdesproduct, pinremoved, pidthumb, pdescode, pdesbarcode, pdtregister);
        
        SET pidproduct = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_products        
        SET 
            idproducttype = pidproducttype,
            desproduct = pdesproduct,
            inremoved = pinremoved,
            idthumb = pidthumb,
            descode = pdescode,
            desbarcode = pdesbarcode,
            dtregister = pdtregister        
        WHERE idproduct = pidproduct;

    END IF;

    CALL sp_products_get(pidproduct);

END;