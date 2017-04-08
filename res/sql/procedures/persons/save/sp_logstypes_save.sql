CREATE PROCEDURE sp_logstypes_save(
pidlogtype INT,
pdeslogtype VARCHAR(32)
)
BEGIN

    IF pidlogtype = 0 THEN
    
        INSERT INTO tb_logstypes (deslogtype)
        VALUES(pdeslogtype);
        
        SET pidlogtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_logstypes        
        SET 
            deslogtype = pdeslogtype
        WHERE idlogtype = pidlogtype;

    END IF;

    CALL sp_logstypes_get(pidlogtype);

END