CREATE PROCEDURE sp_productstypes_save(
pidproducttype INT,
pdesproducttype VARCHAR(64)
)
BEGIN

    IF pidproducttype = 0 THEN
    
        INSERT INTO tb_productstypes (desproducttype)
        VALUES(pdesproducttype);
        
        SET pidproducttype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_productstypes        
        SET 
            desproducttype = pdesproducttype
        WHERE idproducttype = pidproducttype;

    END IF;

    CALL sp_productstypes_get(pidproducttype);

END