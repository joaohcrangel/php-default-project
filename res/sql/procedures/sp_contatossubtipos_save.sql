CREATE PROCEDURE sp_contatossubtipos_save(
pidcontatosubtipo INT,
pidcontatotipo INT,
pdescontatosubtipo VARCHAR(32),
pidusuario INT
)
BEGIN

    IF pidcontatosubtipo = 0 THEN
    
        INSERT INTO tb_contatossubtipos (idcontatotipo, descontatosubtipo, idusuario)
        VALUES(pidcontatotipo, pdescontatosubtipo, pidusuario);
        
        SET pidcontatosubtipo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_contatossubtipos        
        SET 
            descontatosubtipo = pdescontatosubtipo,
            idusuario = pidusuario,
            idcontatotipo = pidcontatotipo
        WHERE idcontatosubtipo = pidcontatosubtipo;

    END IF;

    CALL sp_contatossubtipos_get(pidcontatosubtipo);

END