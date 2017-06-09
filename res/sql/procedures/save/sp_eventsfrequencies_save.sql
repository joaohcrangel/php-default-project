CREATE PROCEDURE sp_eventsfrequencies_save(
pidfrequency INT,
pdesfrequency VARCHAR(32)
)
BEGIN

    IF pidfrequency = 0 THEN
    
        INSERT INTO tb_eventsfrequencies (desfrequency)
        VALUES(pdesfrequency);
        
        SET pidfrequency = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsfrequencies        
        SET 
            desfrequency = pdesfrequency    
        WHERE idfrequency = pidfrequency;

    END IF;

    CALL sp_eventsfrequencies_get(pidfrequency);

END;