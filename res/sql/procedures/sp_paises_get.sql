CREATE PROCEDURE sp_paises_get(
pidpais INT
)
BEGIN

    SELECT *    
    FROM tb_paises    
    WHERE idpais = pidpais;

END