CREATE PROCEDURE sp_enderecos_save(
pidendereco INT,
pidenderecotipo INT,
pidpessoa INT,
pdesendereco VARCHAR(64)

)
BEGIN

    IF pidendereco = 0 THEN
    
        INSERT INTO tb_enderecos (idenderecotipo, idpessoa, desendereco)
        VALUES(pidenderecotipo, pidpessoa, pdesendereco);
        
        SET pidendereco = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_enderecos

        SET 
            idenderecotipo = pidenderecotipo,
            idpessoa = pidpessoa,
            desendereco = pdesendereco

        WHERE idendereco = pidendereco;

    END IF;

    CALL sp_enderecos_get(pidendereco);

END