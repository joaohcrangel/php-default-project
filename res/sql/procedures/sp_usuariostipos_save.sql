CREATE PROCEDURE sp_usuariostipos_save(
pidusuariotipo INT,
pdesusuariotipo VARCHAR(32)
)
BEGIN

    IF pidusuariotipo = 0 THEN
    
        INSERT INTO tb_usuariostipos (desusuariotipo)
        VALUES(pdesusuariotipo);
        
        SET pidusuariotipo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_usuariostipos        
        SET 
            desusuariotipo = pdesusuariotipo        
        WHERE idusuariotipo = pidusuariotipo;

    END IF;

    CALL sp_usuariostipos_get(pidusuariotipo);

END