CREATE PROCEDURE sp_countries_remove(
pidcountry INT
)
BEGIN

    DELETE FROM tb_countries 
    WHERE idcountry = pidcountry;

END