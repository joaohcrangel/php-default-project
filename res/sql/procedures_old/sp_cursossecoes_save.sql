CREATE PROCEDURE sp_cursossecoes_save(
pidsecao INT,
pdessecao VARCHAR(128),
pnrordem INT,
pidcurso INT
)
BEGIN

    IF pidsecao = 0 THEN
    
        INSERT INTO tb_cursossecoes (dessecao, nrordem, idcurso)
        VALUES(pdessecao, pnrordem, pidcurso);
        
        SET pidsecao = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_cursossecoes        
        SET 
            dessecao = pdessecao,
            nrordem = pnrordem,
            idcurso = pidcurso        
        WHERE idsecao = pidsecao;

    END IF;

    CALL sp_cursossecoes_get(pidsecao);

END