CREATE PROCEDURE sp_usuarios_save(
pidusuario INT,
pidpessoa INT,
pdesusuario VARCHAR(128),
pdessenha VARCHAR(256),
pinbloqueado BIT

)
BEGIN

    IF pidusuario = 0 THEN
    
        INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, inbloqueado)
        VALUES(pidpessoa, pdesusuario, pdessenha, pinbloqueado);
        
        SET pidusuario = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_usuarios

        SET 
            idpessoa = pidpessoa,
            desusuario = pdesusuario,
            dessenha = pdessenha,
            inbloqueado = pinbloqueado

        WHERE idusuario = pidusuario;

    END IF;

    CALL sp_usuario_get(pidusuario);

END