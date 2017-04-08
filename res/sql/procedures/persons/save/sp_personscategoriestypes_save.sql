CREATE PROCEDURE sp_personscategoriestypes_save(
pidcategory INT,
pdescategory VARCHAR(32)
)
BEGIN

    IF pidcategory = 0 THEN
    
        INSERT INTO tb_personscategoriestypes (descategory)
        VALUES(pdescategory);
        
        SET pidcategory = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personscategoriestypes        
        SET 
            descategory = pdescategory        
        WHERE idcategory = pidcategory;

    END IF;

    CALL sp_personscategoriestypes_get(pidcategory);

END