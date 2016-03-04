CREATE PROCEDURE sp_contato_save(
pidcontato INT,
pidcontatotipo INT,
pidpessoa INT,
pdescontato VARCHAR(64)

)
BEGIN

    IF pidcontato = 0 THEN
    
        INSERT INTO tb_contatos (idcontatotipo, idpessoa, descontato)
        VALUES(pidcontatotipo, pidpessoa, pdescontato);
        
        SET pidcontato = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contatos

        SET 
            idcontatotipo = pidcontatotipo,
            idpessoa = pidpessoa,
            descontato = pdescontato

        WHERE idcontato = pidcontato;

    END IF;

    CALL sp_contato_get(pidcontato);

END