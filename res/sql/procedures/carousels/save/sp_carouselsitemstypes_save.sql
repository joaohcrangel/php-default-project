CREATE PROCEDURE sp_carouselsitemstypes_save(
pidtype INT,
pdestype VARCHAR(32)
)
BEGIN

    IF pidtype = 0 THEN
    
        INSERT INTO tb_carouselsitemstypes (destype)
        VALUES(pdestype);
        
        SET pdestype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carouselsitemstypes        
        SET 
            destype = pdestype        
        WHERE idtype = pidtype;

    END IF;

    CALL sp_carouselsitemstypes_get(pidtype);

END