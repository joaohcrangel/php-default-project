CREATE PROCEDURE sp_urls_save(
pidurl INT,
pdesurl VARCHAR(128),
pdestitle VARCHAR(64)
)
BEGIN

    IF pidurl = 0 THEN
    
        INSERT INTO tb_urls (desurl, destitle)
        VALUES(pdesurl, pdestitle);
        
        SET pidurl = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_urls        
        SET 
            desurl = pdesurl,
            destitle = pdestitle        
        WHERE idurl = pidurl;

    END IF;

    CALL sp_urls_get(pidurl);

END