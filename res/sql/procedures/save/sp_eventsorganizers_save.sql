CREATE PROCEDURE sp_eventsorganizers_save(
pidorganizer INT,
pdesorganizer VARCHAR(64)
)
BEGIN

    IF pidorganizer = 0 THEN
    
        INSERT INTO tb_eventsorganizers (desorganizer)
        VALUES(pdesorganizer);
        
        SET pidorganizer = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsorganizers        
        SET 
            desorganizer = pdesorganizer    
        WHERE idorganizer = pidorganizer;

    END IF;

    CALL sp_eventsorganizers_get(pidorganizer);

END;