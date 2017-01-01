CREATE PROCEDURE sp_usuarios_save(
pidusuario INT,
pidpessoa INT,
pdesusuario VARCHAR(128),
pdessenha VARCHAR(256),
pinbloqueado BIT,
pidusuariotipo INT
)
BEGIN

    IF pidusuario = 0 THEN
    
        INSERT INTO tb_usuarios (idpessoa, desusuario, dessenha, inbloqueado, idusuariotipo)
        VALUES(pidpessoa, pdesusuario, pdessenha, pinbloqueado, pidusuariotipo);
        
        SET pidusuario = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_usuarios

        SET 
            idpessoa = pidpessoa,
            desusuario = pdesusuario,
            dessenha = pdessenha,
            inbloqueado = pinbloqueado,
            idusuariotipo = pidusuariotipo

        WHERE idusuario = pidusuario;

    END IF;

    CALL sp_usuarios_get(pidusuario);

END