CREATE PROCEDURE sp_countries_get(
pidcountry INT
)
BEGIN

    SELECT *    
    FROM tb_countries    
    WHERE idcountry = pidcountry;

END