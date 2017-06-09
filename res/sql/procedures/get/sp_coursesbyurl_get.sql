CREATE PROCEDURE sp_coursesbyurl_get(
pdesurl VARCHAR(256)
)
BEGIN

	SELECT a.*, g.*, CONCAT(e.desdirectory, e.desfile, ".", e.desextension) AS desbanner,
			CONCAT(f.desdirectory, f.desfile, ".", f.desextension) AS desbrasao
	FROM tb_courses a
		INNER JOIN tb_productscourses b ON a.idcourse = b.idcourse
		INNER JOIN tb_productsdata g ON b.idproduct = g.idproduct
		INNER JOIN tb_coursesurls d ON d.idcourse = a.idcourse
        INNER JOIN tb_urls c ON d.idurl = c.idurl
        INNER JOIN tb_files e ON a.idbanner = e.idfile
        INNER JOIN tb_files f ON a.idbrasao = f.idfile
	WHERE c.desurl = pdesurl;

END
