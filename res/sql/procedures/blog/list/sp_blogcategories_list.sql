CREATE PROCEDURE sp_blogcategories_list()
BEGIN

    SELECT a.*, COUNT(b.idpost) AS nrposts, c.desurl FROM tb_blogcategories a
    	LEFT JOIN tb_blogpostscategories b ON a.idcategory = b.idcategory
        INNER JOIN tb_urls c ON a.idurl = c.idurl
    GROUP BY a.idcategory;

END