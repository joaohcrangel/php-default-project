CREATE PROCEDURE sp_coursessections_save(
pidsection INT,
pdessection VARCHAR(128),
pnrorder INT,
pidcourse INT
)
BEGIN

    IF pidsection = 0 THEN
    
        INSERT INTO tb_coursessections (dessection, nrorder, idcourse)
        VALUES(pdessection, pnrorder, pidcourse);
        
        SET pidsection = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_coursessections       
        SET 
            dessection = pdessection,
            nrorder = pnrorder,
            idcourse = pidcourse        
        WHERE idsection = pidsection;

    END IF;

    CALL sp_coursessections_get(pidsection);

END