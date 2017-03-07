CREATE PROCEDURE sp_pessoasdispositivos_save(
piddispositivo INT,
pidpessoa INT,
pdesdispositivo VARCHAR(128),
pdesid VARCHAR(512),
pdessistema VARCHAR(128)
)
BEGIN

    IF piddispositivo = 0 THEN
    
        INSERT INTO tb_pessoasdispositivos (idpessoa, desdispositivo, desid, dessistema)
        VALUES(pidpessoa, pdesdispositivo, pdesid, pdessistema);
        
        SET piddispositivo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pessoasdispositivos        
        SET 
            idpessoa = pidpessoa,
            desdispositivo = pdesdispositivo,
            desid = pdesid,
            dessistema = pdessistema        
        WHERE iddispositivo = piddispositivo;

    END IF;

    CALL sp_pessoasdispositivos_get(piddispositivo);

END