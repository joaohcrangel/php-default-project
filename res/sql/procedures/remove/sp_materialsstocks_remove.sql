CREATE PROCEDURE sp_materialsstocks_remove(
pidstock INT
)
BEGIN

    DELETE FROM tb_materialsstocks 
    WHERE idstock = pidstock;

END;