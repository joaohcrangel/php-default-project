CREATE PROCEDURE sp_ordersnegotiationstypes_save(
pidnegotiation INT,
pdesnegotiation VARCHAR(64)
)
BEGIN

    IF pidnegotiation = 0 THEN
    
        INSERT INTO tb_ordersnegotiationstypes (desnegotiation)
        VALUES(pdesnegotiation);
        
        SET pidnegotiation = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_ordersnegotiationstypes        
        SET 
            desnegotiation = pdesnegotiation        
        WHERE idnegotiation = pidnegotiation;

    END IF;

    CALL sp_ordersnegotiationstypes_get(pidnegotiation);

END