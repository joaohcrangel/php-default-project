CREATE PROCEDURE sp_cursoscurriculos_save(
pidcurriculo INT,
pdescurriculo VARCHAR(128),
pidsecao INT,
pdesdescricao VARCHAR(2048),
pnrordem VARCHAR(45)
)
BEGIN

    IF pidcurriculo = 0 THEN
    
        INSERT INTO tb_cursoscurriculos (descurriculo, idsecao, desdescricao, nrordem)
        VALUES(pdescurriculo, pidsecao, pdesdescricao, pnrordem);
        
        SET pidcurriculo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_cursoscurriculos        
        SET 
            descurriculo = pdescurriculo,
            idsecao = pidsecao,
            desdescricao = pdesdescricao,
            nrordem = pnrordem        
        WHERE idcurriculo = pidcurriculo;

    END IF;

    CALL sp_cursoscurriculos_get(pidcurriculo);

END