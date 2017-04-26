CREATE PROCEDURE sp_addressestypes_save(
pidaddresstype INT,
pdesaddresstype VARCHAR(64)
)
BEGIN

    IF pidaddresstype = 0 THEN
    
        INSERT INTO tb_addressestypes (desaddresstype)
        VALUES(pdesaddresstype);
        
        SET pidaddresstype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_addressestypes        
        SET 
            desaddresstype = pdesaddresstype
        WHERE idaddresstype = pidaddresstype;

    END IF;

    CALL sp_addressestypes_get(pidaddresstype);

END