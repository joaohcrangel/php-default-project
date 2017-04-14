CREATE PROCEDURE sp_blogposts_get(
pidpost INT
)
BEGIN

    SELECT a.*, b.desurl, CONCAT(c.desdirectory, c.desfile, '.',c.desextension) AS despath, (SELECT GROUP_CONCAT(d.idtag) FROM tb_blogpoststags d WHERE d.idpost = pidpost) AS destags, (SELECT GROUP_CONCAT(e.idcategory) FROM tb_blogpostscategories e WHERE e.idpost = pidpost) AS descategories FROM tb_blogposts a
    	INNER JOIN tb_urls b ON a.idurl = b.idurl
        LEFT JOIN tb_files c ON a.idcover = c.idfile
    WHERE a.idpost = pidpost;

END