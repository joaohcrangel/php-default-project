CREATE PROCEDURE sp_blogcategories_get(
pidcategory INT
)
BEGIN

    SELECT *    
    FROM tb_blogcategories    
    WHERE idcategory = pidcategory;

END