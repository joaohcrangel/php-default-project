CREATE PROCEDURE sp_contatos_save(
pidcontato INT,
pidcontatotipo INT,
pidcontatosubtipo INT,
pidpessoa INT,
pdescontato VARCHAR(128),
pinprincipal BIT
)
BEGIN

    IF pidcontato = 0 THEN
    
        INSERT INTO tb_contatos (idcontatotipo, idpessoa, descontato, inprincipal, idcontatosubtipo)
        VALUES(pidcontatotipo, pidpessoa, pdescontato, pinprincipal, pidcontatosubtipo);
        
        SET pidcontato = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contatos        
        SET 
            idcontatotipo = pidcontatotipo,
            idpessoa = pidpessoa,
            descontato = pdescontato,
            inprincipal = pinprincipal,
            idcontatosubtipo = pidcontatosubtipo        
        WHERE idcontato = pidcontato;

    END IF;

    CALL sp_contatos_get(pidcontato);

END