CREATE PROCEDURE sp_cities_remove(
pidcity INT
)
BEGIN

    DELETE FROM tb_cities 
    WHERE idcity = pidcity;

END