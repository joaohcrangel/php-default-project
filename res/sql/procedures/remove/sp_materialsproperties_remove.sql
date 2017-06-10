CREATE PROCEDURE sp_materialsproperties_remove(
pidproperty INT
)
BEGIN

    DELETE FROM tb_materialsproperties 
    WHERE idproperty = pidproperty;

END;