CREATE PROCEDURE sp_materialsstockstags_remove(
pidstock INT
)
BEGIN

    DELETE FROM tb_materialsstockstags 
    WHERE idstock = pidstock;

END;