CREATE PROCEDURE sp_blogposts_get(
pidpost INT
)
BEGIN

    SELECT a.*, b.desurl, CONCAT(c.desdirectory, c.desfile, '.',c.desextension) AS despath FROM tb_blogposts a
    	INNER JOIN tb_urls b ON a.idurl = b.idurl
        LEFT JOIN tb_files c ON a.idcover = c.idfile
    WHERE idpost = pidpost;

END