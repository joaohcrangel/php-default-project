CREATE PROCEDURE sp_projectsstandstypes_save(
pidstandtype INT,
pdesstandtype VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF pidstandtype = 0 THEN
    
        INSERT INTO tb_projectsstandstypes (desstandtype, dtregister)
        VALUES(pdesstandtype, pdtregister);
        
        SET pidstandtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectsstandstypes        
        SET 
            desstandtype = pdesstandtype,
            dtregister = pdtregister        
        WHERE idstandtype = pidstandtype;

    END IF;

    CALL sp_projectsstandstypes_get(pidstandtype);

END;