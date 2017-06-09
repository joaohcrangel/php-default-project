CREATE PROCEDURE sp_materialspropertiesvalues_get(
pidmaterial INT
)
BEGIN

    SELECT *    
    FROM tb_materialspropertiesvalues    
    WHERE idmaterial = pidmaterial;

END;