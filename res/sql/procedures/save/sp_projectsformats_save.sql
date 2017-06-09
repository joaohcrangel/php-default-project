CREATE PROCEDURE sp_projectsformats_save(
pidformat INT,
pdesformat VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF pidformat = 0 THEN
    
        INSERT INTO tb_projectsformats (desformat, dtregister)
        VALUES(pdesformat, pdtregister);
        
        SET pidformat = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectsformats        
        SET 
            desformat = pdesformat,
            dtregister = pdtregister        
        WHERE idformat = pidformat;

    END IF;

    CALL sp_projectsformats_get(pidformat);

END;