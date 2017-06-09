CREATE PROCEDURE sp_materialsstockstags_get(
pidstock INT
)
BEGIN

    SELECT *    
    FROM tb_materialsstockstags    
    WHERE idstock = pidstock;

END;