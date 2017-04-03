CREATE PROCEDURE sp_blogtags_save(
pidtag INT,
pdestag VARCHAR(32)
)
BEGIN

    IF pidtag = 0 THEN
    
        INSERT INTO tb_blogtags (destag)
        VALUES(pdestag);
        
        SET pidtag = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_blogtags        
        SET 
            destag = pdestag
        WHERE idtag = pidtag;

    END IF;

    CALL sp_blogtags_get(pidtag);

END