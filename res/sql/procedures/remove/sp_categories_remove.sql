CREATE PROCEDURE sp_categories_remove(
pidcategory INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_categories WHERE idcategoryfather = pidcategory) THEN
    
		DELETE FROM tb_categories WHERE idcategoryfather = pidcategory;
        
	END IF;

    DELETE FROM tb_categories 
    WHERE idcategory = pidcategory;

END