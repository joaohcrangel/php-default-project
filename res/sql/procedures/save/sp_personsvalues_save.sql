CREATE PROCEDURE sp_personsvalues_save(
pidpersonvalue INT,
pidperson INT,
pidfield INT,
pdesvalue VARCHAR(128)
)
BEGIN

    IF pidpersonvalue = 0 THEN
    
        INSERT INTO tb_personsvalues (idperson, idfield, desvalue)
        VALUES(pidperson, pidfield, pdesvalue);
        
        SET pidpersonvalue = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personsvalues        
        SET 
            idperson = pidperson,
            idfield = pidfield,
            desvalue = pdesvalue
        WHERE idpersonvalue = pidpersonvalue;

    END IF;

    CALL sp_personsvalues_get(pidpersonvalue);

END