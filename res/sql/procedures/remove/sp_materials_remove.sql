CREATE PROCEDURE sp_materials_remove(
pidmaterial INT
)
BEGIN

    DELETE FROM tb_materials 
    WHERE idmaterial = pidmaterial;

END;