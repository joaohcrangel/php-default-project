CREATE PROCEDURE sp_categoriesfrompost_list(
pidpost INT
)
BEGIN

	SELECT a.* FROM tb_blogcategories a
		INNER JOIN tb_blogpostscategories b ON a.idcategory = b.idcategory
	WHERE b.idpost = pidpost;

END