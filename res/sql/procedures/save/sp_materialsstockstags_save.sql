CREATE PROCEDURE sp_materialsstockstags_save(
pidstock INT,
pidtag INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidstock = 0 THEN
    
        INSERT INTO tb_materialsstockstags (dtregister)
        VALUES(pdtregister);
        
        SET pidstock = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_materialsstockstags        
        SET 
            dtregister = pdtregister        
        WHERE idstock = pidstock;

    END IF;

    CALL sp_materialsstockstags_get(pidstock);

END;