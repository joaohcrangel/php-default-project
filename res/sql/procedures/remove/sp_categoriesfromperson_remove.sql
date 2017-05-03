CREATE PROCEDURE sp_categoriesfromperson_remove(
pidperson INT
)
BEGIN

    DELETE FROM tb_personscategories WHERE idperson = pidperson;

END