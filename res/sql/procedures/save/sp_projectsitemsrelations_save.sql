CREATE PROCEDURE sp_projectsitemsrelations_save(
pidproject INT,
piditem INT,
pvlqtd INT,
pdesobs VARCHAR(512),
pdtregister TIMESTAMP
)
BEGIN

    IF pidproject = 0 THEN
    
        INSERT INTO tb_projectsitemsrelations (vlqtd, desobs, dtregister)
        VALUES(pvlqtd, pdesobs, pdtregister);
        
        SET pidproject = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectsitemsrelations        
        SET 
            vlqtd = pvlqtd,
            desobs = pdesobs,
            dtregister = pdtregister        
        WHERE idproject = pidproject;

    END IF;

    CALL sp_projectsitemsrelations_get(pidproject);

END;