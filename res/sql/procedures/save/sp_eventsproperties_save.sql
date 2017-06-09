CREATE PROCEDURE sp_eventsproperties_save(
pidproperty INT,
pdesproperty VARCHAR(45),
pdtregister TIMESTAMP
)
BEGIN

    IF pidproperty = 0 THEN
    
        INSERT INTO tb_eventsproperties (desproperty, dtregister)
        VALUES(pdesproperty, pdtregister);
        
        SET pidproperty = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_eventsproperties        
        SET 
            desproperty = pdesproperty,
            dtregister = pdtregister        
        WHERE idproperty = pidproperty;

    END IF;

    CALL sp_eventsproperties_get(pidproperty);

END;