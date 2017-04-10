CREATE PROCEDURE sp_configuracoes_save(
pidconfiguracao INT,
pdesconfiguracao VARCHAR(64),
pdesvalor VARCHAR(2048),
pdesdescricao VARCHAR(256),
pidconfiguracaotipo INT
)
BEGIN

    IF pidconfiguracao = 0 THEN
    
        INSERT INTO tb_configuracoes (desconfiguracao, desvalor, idconfiguracaotipo, desdescricao)
        VALUES(pdesconfiguracao, pdesvalor, pidconfiguracaotipo, pdesdescricao);
        
        SET pidconfiguracao = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_configuracoes        
        SET 
            desconfiguracao = pdesconfiguracao,
            desvalor = pdesvalor,
            idconfiguracaotipo = pidconfiguracaotipo,
            desdescricao = pdesdescricao   
        WHERE idconfiguracao = pidconfiguracao;

    END IF;

    CALL sp_configuracoes_get(pidconfiguracao);

END