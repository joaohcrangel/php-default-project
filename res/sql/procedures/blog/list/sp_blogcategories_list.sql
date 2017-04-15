CREATE PROCEDURE sp_blogcategories_list()
BEGIN

    SELECT a.*, COUNT(b.idpost) AS nrposts FROM tb_blogcategories a
    	LEFT JOIN tb_blogpostscategories b ON a.idcategory = b.idcategory
    GROUP BY a.idcategory;

END