CREATE PROCEDURE sp_postsfromauthor_list(
pidauthor INT
)
BEGIN

	SELECT a.*, b.desauthor, f.desurl, CONCAT(e.desdirectory, e.desfile, '.', e.desextension) AS descover, 
		(
			SELECT COUNT(idcomment) FROM tb_blogcomments WHERE idpost = a.idpost
		) AS nrcomments,
		(
			SELECT GROUP_CONCAT(b.destag)
			FROM tb_blogpoststags a
			LEFT JOIN tb_blogtags b ON a.idtag = b.idtag
			WHERE idpost = a.idpost
		) AS destags FROM tb_blogposts a
		INNER JOIN tb_blogauthors b ON a.idauthor = b.idauthor
		LEFT JOIN tb_blogpostscategories c ON a.idpost = c.idpost
		LEFT JOIN tb_blogpoststags d ON a.idpost = d.idpost
		LEFT JOIN tb_files e ON a.idcover = e.idfile
		LEFT JOIN tb_urls f ON a.idurl = f.idurl
		LEFT JOIN tb_blogcomments g ON a.idpost = g.idpost
	WHERE b.idauthor = pidauthor GROUP BY b.idauthor;

END