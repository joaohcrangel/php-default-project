CREATE PROCEDURE sp_eventsproperties_remove(
pidproperty INT
)
BEGIN

    DELETE FROM tb_eventsproperties 
    WHERE idproperty = pidproperty;

END;