CREATE PROCEDURE sp_eventsproperties_save(
pidproperty INT,
pdesproperty VARCHAR(45)
)
BEGIN

    IF pidproperty = 0 THEN
    
        INSERT INTO tb_eventsproperties (desproperty)
        VALUES(pdesproperty);
        
        SET pidproperty = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsproperties        
        SET 
            desproperty = pdesproperty      
        WHERE idproperty = pidproperty;

    END IF;

    CALL sp_eventsproperties_get(pidproperty);

END;