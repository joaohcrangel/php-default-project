CREATE PROCEDURE sp_categories_save(
pidcategory INT,
pidcategoryfather INT,
pdescategory VARCHAR(128)
)
BEGIN

    IF pidcategory = 0 THEN
    
        INSERT INTO tb_categories (idcategoryfather, descategory)
        VALUES(pidcategoryfather, pdescategory);
        
        SET pidcategory = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_categories        
        SET 
            idcategoryfather = pidcategoryfather,
            descategory = pdescategory      
        WHERE idcategory = pidcategory;

    END IF;

    CALL sp_categories_get(pidcategory);

END