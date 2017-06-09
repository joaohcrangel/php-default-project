CREATE PROCEDURE sp_categories_get(
pidcategory INT
)
BEGIN

    SELECT *    
    FROM tb_categories    
    WHERE idcategory = pidcategory;

END