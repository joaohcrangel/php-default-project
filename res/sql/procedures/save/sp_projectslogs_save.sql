CREATE PROCEDURE sp_projectslogs_save(
pidlog INT,
pidproject INT,
pidstatus INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidlog = 0 THEN
    
        INSERT INTO tb_projectslogs (idproject, idstatus, dtregister)
        VALUES(pidproject, pidstatus, pdtregister);
        
        SET pidlog = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectslogs        
        SET 
            idproject = pidproject,
            idstatus = pidstatus,
            dtregister = pdtregister        
        WHERE idlog = pidlog;

    END IF;

    CALL sp_projectslogs_get(pidlog);

END;