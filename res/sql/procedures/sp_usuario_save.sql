CREATE PROCEDURE sp_usuario_save(
pidusuario INT,
pidpessoa INT,
pdesusuario VARCHAR(128),
pdessenha VARCHAR(256),
pinbloqueado BIT

)
BEGIN

    IF pidusuario = 0 THEN
    
        INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, inbloqueado)
        VALUES(pidpessoa, pdesusuario, md5(pdessenha), pinbloqueado);
        
        SET pidusuario = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_usuarios

        SET 
            idpessoa = pidpessoa,
            desusuario = pdesusuario,
            dessenha = md5(pdessenha),
            inbloqueado = pinbloqueado

        WHERE idusuario = pidusuario;

    END IF;

    CALL sp_usuario_get(pidusuario);

END