CREATE PROCEDURE sp_urls_save(
pidurl INT,
pdesurl VARCHAR(128),
pdestitulo VARCHAR(64)
)
BEGIN

    IF pidurl = 0 THEN
    
        INSERT INTO tb_urls (desurl, destitulo)
        VALUES(pdesurl, pdestitulo);
        
        SET pidurl = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_urls        
        SET 
            desurl = pdesurl,
            destitulo = pdestitulo        
        WHERE idurl = pidurl;

    END IF;

    CALL sp_urls_get(pidurl);

END