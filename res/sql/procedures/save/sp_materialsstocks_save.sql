CREATE PROCEDURE sp_materialsstocks_save(
pidstock INT,
pidmaterial INT,
pdteliminated DATETIME,
pdtregister TIMESTAMP
)
BEGIN

    IF pidstock = 0 THEN
    
        INSERT INTO tb_materialsstocks (idmaterial, dteliminated, dtregister)
        VALUES(pidmaterial, pdteliminated, pdtregister);
        
        SET pidstock = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_materialsstocks        
        SET 
            idmaterial = pidmaterial,
            dteliminated = pdteliminated,
            dtregister = pdtregister        
        WHERE idstock = pidstock;

    END IF;

    CALL sp_materialsstocks_get(pidstock);

END;