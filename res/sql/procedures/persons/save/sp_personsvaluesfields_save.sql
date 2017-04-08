CREATE PROCEDURE sp_personsvaluesfields_save(
pidfield INT,
pdesfield VARCHAR(128)
)
BEGIN

    IF pidfield = 0 THEN
    
        INSERT INTO tb_personsvaluesfields (desfield)
        VALUES(pdesfield);
        
        SET pidfield = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personsvaluesfields        
        SET 
            desfield = pdesfield
        WHERE idfield = pidfield;

    END IF;

    CALL sp_personsvaluesfields_get(pidfield);

END