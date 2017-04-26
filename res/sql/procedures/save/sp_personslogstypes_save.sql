CREATE PROCEDURE sp_personslogstypes_save(
pidlogtype INT,
pdeslogtype VARCHAR(32)
)
BEGIN

    IF pidlogtype = 0 THEN
    
        INSERT INTO tb_personslogstypes (deslogtype)
        VALUES(pdeslogtype);
        
        SET pidlogtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personslogstypes        
        SET 
            deslogtype = pdeslogtype
        WHERE idlogtype = pidlogtype;

    END IF;

    CALL sp_personslogstypes_get(pidlogtype);

END