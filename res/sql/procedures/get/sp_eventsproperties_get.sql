CREATE PROCEDURE sp_eventsproperties_get(
pidproperty INT
)
BEGIN

    SELECT *    
    FROM tb_eventsproperties    
    WHERE idproperty = pidproperty;

END;