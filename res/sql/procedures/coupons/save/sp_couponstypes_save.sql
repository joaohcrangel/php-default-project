CREATE PROCEDURE sp_couponstypes_save(
pidcoupontype INT,
pdescoupontype VARCHAR(128),
pdtregister TIMESTAMP
)
BEGIN

    IF pidcoupontype = 0 THEN
    
        INSERT INTO tb_couponstypes (descoupontype, dtregister)
        VALUES(pdescoupontype, pdtregister);
        
        SET pidcoupontype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_couponstypes        
        SET 
            descoupontype = pdescoupontype,
            dtregister = pdtregister        
        WHERE idcoupontype = pidcoupontype;

    END IF;

    CALL sp_couponstypes_get(pidcoupontype);

END