CREATE PROCEDURE sp_eventsorganizers_save(
pidorganizer INT,
pdesorganizer VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF pidorganizer = 0 THEN
    
        INSERT INTO tb_eventsorganizers (desorganizer, dtregister)
        VALUES(pdesorganizer, pdtregister);
        
        SET pidorganizer = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsorganizers        
        SET 
            desorganizer = pdesorganizer,
            dtregister = pdtregister        
        WHERE idorganizer = pidorganizer;

    END IF;

    CALL sp_eventsorganizers_get(pidorganizer);

END;