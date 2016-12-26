CREATE PROCEDURE sp_documentos_save(
piddocumento INT,
piddocumentotipo INT,
pidpessoa INT,
pdesdocumento VARCHAR(64)

)
BEGIN

    IF piddocumento = 0 THEN
    
        INSERT INTO tb_documentos (iddocumentotipo, idpessoa, desdocumento)
        VALUES(piddocumentotipo, pidpessoa, pdesdocumento);
        
        SET piddocumento = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_documentos

        SET 
            iddocumentotipo = piddocumentotipo,
            idpessoa = pidpessoa,
            desdocumento = pdesdocumento

        WHERE iddocumento = piddocumento;

    END IF;

    CALL sp_documentos_get(piddocumento);

END