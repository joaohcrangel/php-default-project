CREATE PROCEDURE sp_urls_get(
pidurl INT
)
BEGIN

    SELECT *    
    FROM tb_urls    
    WHERE idurl = pidurl;

END