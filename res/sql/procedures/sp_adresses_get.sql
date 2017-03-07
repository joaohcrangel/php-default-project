CREATE PROCEDURE sp_adresses_get(
pidadress INT
)
BEGIN

    SELECT *    
    FROM tb_adresses    
    WHERE idadress = pidadress;

END