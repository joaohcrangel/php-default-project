CREATE PROCEDURE sp_workers_save(
pidworker INT,
pidperson INT,
pidjobposition INT,
pidphoto INT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidworker = 0 THEN
    
        INSERT INTO tb_workers (idperson, idjobposition, idphoto, dtregister)
        VALUES(pidperson, pidjobposition, pidphoto, pdtregister);
        
        SET pidworker = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_workers        
        SET 
            idperson = pidperson,
            idjobposition = pidjobposition,
            idphoto = pidphoto,
            dtregister = pdtregister        
        WHERE idworker = pidworker;

    END IF;

    CALL sp_workers_get(pidworker);

END;