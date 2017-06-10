CREATE PROCEDURE sp_materialsstocks_get(
pidstock INT
)
BEGIN

    SELECT *    
    FROM tb_materialsstocks    
    WHERE idstock = pidstock;

END;