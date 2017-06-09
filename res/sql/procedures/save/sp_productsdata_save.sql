CREATE PROCEDURE sp_productsdata_save(
pidproduct INT
)
BEGIN

    CALL sp_productsdata_remove(pidproduct);
    
    INSERT INTO tb_productsdata (
        idproduct, idproducttype,
        desproduct, vlprice, desproducttype,
        dtstart, dtend,
        inremoved,
        idurl, desurl
    )
    SELECT 
    a.idproduct, a.idproducttype,
    a.desproduct, c.vlprice, b.desproducttype,
    c.dtstart, c.dtend,
    a.inremoved,
    e.idurl, e.desurl
    FROM tb_products a
    INNER JOIN tb_productstypes b ON a.idproducttype = b.idproducttype
    LEFT JOIN tb_productsprices c ON a.idproduct = c.idproduct
    LEFT JOIN tb_productsurls d ON a.idproduct = d.idproduct
    LEFT JOIN tb_urls e ON d.idurl = e.idurl
    WHERE 
        a.idproduct = pidproduct
        AND
        a.inremoved = 0
        AND
        (
            NOW() BETWEEN c.dtstart AND c.dtend
            OR
            (
                dtstart <= NOW()
                AND
                dtend IS NULL
            )
            OR
            (
                dtstart IS NULL 
                AND 
                dtstart IS NULL
            )
        )
    ORDER BY c.dtregister DESC
    LIMIT 1;

END