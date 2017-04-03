CREATE PROCEDURE sp_userslogstypes_save(
pidlogtype INT,
pdeslogtype VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidlogtype = 0 THEN
    
        INSERT INTO tb_userslogstypes (deslogtype, dtregister)
        VALUES(pdeslogtype, pdtregister);
        
        SET pidlogtype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_userslogstypes        
        SET 
            deslogtype = pdeslogtype,
            dtregister = pdtregister        
        WHERE idlogtype = pidlogtype;

    END IF;

    CALL sp_userslogstypes_get(pidlogtype);

END