CREATE PROCEDURE sp_tags_save(
pidtag INT,
pdestag VARCHAR(32),
pinactive BIT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidtag = 0 THEN
    
        INSERT INTO tb_tags (destag, inactive, dtregister)
        VALUES(pdestag, pinactive, pdtregister);
        
        SET pidtag = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_tags        
        SET 
            destag = pdestag,
            inactive = pinactive,
            dtregister = pdtregister        
        WHERE idtag = pidtag;

    END IF;

    CALL sp_tags_get(pidtag);

END;