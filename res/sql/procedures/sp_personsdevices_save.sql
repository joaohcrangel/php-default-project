CREATE PROCEDURE sp_personsdevices_save(
piddevice INT,
pidperson INT,
pdesdevice VARCHAR(128),
pdesid VARCHAR(512),
pdessystem VARCHAR(128)
)
BEGIN

    IF piddevice = 0 THEN
    
        INSERT INTO tb_personsdevices (idperson, desdevice, desid, dessystem)
        VALUES(pidperson, pdesdevice, pdesid, pdessystem);
        
        SET piddevice = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personsdevices        
        SET 
            idperson = pidperson,
            desdevice = pdesdevice,
            desid = pdesid,
            dessystem = pdessystem        
        WHERE iddevice = piddevice;

    END IF;

    CALL sp_personsdevices_get(piddevice);

END