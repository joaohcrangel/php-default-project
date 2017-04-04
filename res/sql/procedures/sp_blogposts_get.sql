CREATE PROCEDURE sp_blogposts_get(
pidpost INT
)
BEGIN

    SELECT a.*, b.desurl FROM tb_blogposts a
    	INNER JOIN tb_urls b ON a.idurl = b.idurl
    WHERE idpost = pidpost;

END