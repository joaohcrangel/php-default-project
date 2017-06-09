CREATE PROCEDURE sp_materialsproperties_get(
pidproperty INT
)
BEGIN

    SELECT *    
    FROM tb_materialsproperties    
    WHERE idproperty = pidproperty;

END;