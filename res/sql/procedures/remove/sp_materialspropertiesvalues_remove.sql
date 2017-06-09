CREATE PROCEDURE sp_materialspropertiesvalues_remove(
pidmaterial INT
)
BEGIN

    DELETE FROM tb_materialspropertiesvalues 
    WHERE idmaterial = pidmaterial;

END;