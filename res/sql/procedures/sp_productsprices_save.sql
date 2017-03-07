CREATE PROCEDURE sp_productsprices_save(
pidprice INT,
pidproduct INT,
pdtstart DATETIME,
pdtend DATETIME,
pvlprice DECIMAL(10,2)
)
BEGIN

    IF pidprice = 0 THEN
    
        INSERT INTO tb_productsprices (idproduct, dtstart, dtend, vlprice)
        VALUES(pidproduct, pdtstart, pdtend, pvlprice);
        
        SET pidprice = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_productsprices        
        SET 
            idproduct = pidproduct,
            dtstart = pdtstart,
            dtend = pdtend,
            vlprice = pvlprice
        WHERE idprice = pidprice;

    END IF;

    CALL sp_productsprices_get(pidprice);

END