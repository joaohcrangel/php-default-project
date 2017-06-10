CREATE PROCEDURE sp_materials_get(
pidmaterial INT
)
BEGIN

    SELECT *    
    FROM tb_materials    
    WHERE idmaterial = pidmaterial;

END;