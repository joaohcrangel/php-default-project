CREATE PROCEDURE sp_blogcategories_remove(
pidcategory INT
)
BEGIN

    DELETE FROM tb_blogcategories 
    WHERE idcategory = pidcategory;

END