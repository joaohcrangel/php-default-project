CREATE PROCEDURE sp_personscategoriestypes_get(
pidcategory INT
)
BEGIN

    SELECT *    
    FROM tb_personscategoriestypes    
    WHERE idcategory = pidcategory;

END