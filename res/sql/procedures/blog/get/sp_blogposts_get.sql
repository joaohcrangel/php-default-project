CREATE PROCEDURE sp_blogposts_get(
pidpost INT
)
BEGIN

	SELECT a.*, b.desauthor, b.desresume, CONCAT(e1.desdirectory, e1.desfile, '.', e1.desextension) AS desauthorphoto, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS despath, 
		(
			SELECT COUNT(idcomment) FROM tb_blogcomments WHERE idpost = a.idpost
		) AS nrcomments,
		(
			SELECT GROUP_CONCAT(b.destag)
			FROM tb_blogpoststags a
			LEFT JOIN tb_blogtags b ON a.idtag = b.idtag
			WHERE idpost = a.idpost
		) AS destags,
		(
				SELECT GROUP_CONCAT(e.idcategory)
				FROM tb_blogpostscategories e
				WHERE e.idpost = pidpost
		) AS descategories FROM tb_blogposts a
		INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
		LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
		LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
        LEFT JOIN tb_files e ON a.idcover = e.idfile
        LEFT JOIN tb_files e1 ON b.idphoto = e1.idfile
        LEFT JOIN tb_urls f ON a.idurl = f.idurl
        LEFT JOIN tb_blogcomments g ON a.idpost = g.idpost
    WHERE a.idpost = pidpost;
    

END