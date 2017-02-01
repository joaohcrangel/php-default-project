CREATE PROCEDURE sp_documentostipos_save(
piddocumentotipo INT,
pdesdocumentotipo VARCHAR(64)
)
BEGIN

    IF piddocumentotipo = 0 THEN
    
        INSERT INTO tb_documentostipos(desdocumentotipo) VALUES(pdesdocumentotipo);
        
        SET piddocumentotipo = LAST_INSERT_ID();
        
    ELSE
    
        UPDATE tb_documentostipos SET
            desdocumentotipo = pdesdocumentotipo
        WHERE iddocumentotipo = piddocumentotipo;
        
    END IF;
    
    CALL sp_documentostipos_get(piddocumentotipo);

END