CREATE PROCEDURE sp_personscategoriestypes_remove(
pidcategory INT
)
BEGIN

    DELETE FROM tb_personscategoriestypes 
    WHERE idcategory = pidcategory;

END