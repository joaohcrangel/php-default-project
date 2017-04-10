CREATE PROCEDURE sp_countries_save(
pidcountry INT,
pdescountry VARCHAR(64)
)
BEGIN

    IF pidcountry = 0 THEN
    
        INSERT INTO tb_countries (descountry)
        VALUES(pdescountry);
        
        SET pidcountry = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_countries        
        SET 
            descountry = pdescountry
        WHERE idcountry = pidcountry;

    END IF;

    CALL sp_countries_get(pidcountry);

END