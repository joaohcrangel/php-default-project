CREATE PROCEDURE sp_categoriesfromperson_list(
pidperson INT
)
BEGIN

    SELECT c.* FROM tb_persons a
		INNER JOIN tb_personscategories b ON a.idperson = b.idperson
		INNER JOIN tb_personscategoriestypes c ON b.idcategory = c.idcategory
	WHERE a.idperson = pidperson;

END