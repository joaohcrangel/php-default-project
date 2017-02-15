CREATE PROCEDURE sp_configuracoes_save(
pidconfiguracao INT,
pdesconfiguracao VARCHAR(64),
pdesvalor VARCHAR(2048),
pidconfiguracaotipo INT
)
BEGIN

    IF pidconfiguracao = 0 THEN
    
        INSERT INTO tb_configuracoes (desconfiguracao, desvalor, idconfiguracaotipo)
        VALUES(pdesconfiguracao, pdesvalor, pidconfiguracaotipo);
        
        SET pidconfiguracao = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_configuracoes        
        SET 
            desconfiguracao = pdesconfiguracao,
            desvalor = pdesvalor,
            idconfiguracaotipo = pidconfiguracaotipo        
        WHERE idconfiguracao = pidconfiguracao;

    END IF;

    CALL sp_configuracoes_get(pidconfiguracao);

END