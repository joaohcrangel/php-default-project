CREATE PROCEDURE sp_userstypes_save(
pidusertype INT,
pdesusertype VARCHAR(32)
)
BEGIN

    IF pidusertype = 0 THEN
    
        INSERT INTO tb_userstypes (desusertype)
        VALUES(pdesusertype);
        
        SET pidusertype = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_userstypes SET 
            desusertype = pdesusertype
        WHERE idusertype = pidusertype;

    END IF;

    CALL sp_userstypes_get(pidusertype);

END