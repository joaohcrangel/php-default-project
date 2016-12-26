CREATE PROCEDURE sp_contatos_save(
pidcontato INT,
pidcontatotipo INT,
pidpessoa INT,
pdescontato VARCHAR(64),
pinprincipal BIT
)
BEGIN

    IF pidcontato = 0 THEN
    
        INSERT INTO tb_contatos (idcontatotipo, idpessoa, descontato, inprincipal)
        VALUES(pidcontatotipo, pidpessoa, pdescontato, pinprincipal);
        
        SET pidcontato = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contatos
        SET 
            idcontatotipo = pidcontatotipo,
            idpessoa = pidpessoa,
            descontato = pdescontato
            inprincipal = pinprincipal
        WHERE idcontato = pidcontato;

    END IF;

    CALL sp_contatos_get(pidcontato);

END