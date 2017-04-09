CREATE PROCEDURE sp_urls_remove(
pidurl INT
)
BEGIN

    DELETE FROM tb_urls 
    WHERE idurl = pidurl;

END