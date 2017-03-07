CREATE PROCEDURE sp_enderecos_save(
pidendereco INT,
pidenderecotipo INT,
pdesendereco VARCHAR(64),
pdesnumero VARCHAR(128),
pdesbairro VARCHAR(128),
pdescidade VARCHAR(128),
pdesestado VARCHAR(128),
pdespais VARCHAR(32),
pdescep CHAR(8),
pdescomplemento VARCHAR(64),
pinprincipal BIT
)
BEGIN

    IF pidendereco = 0 THEN
    
        INSERT INTO tb_enderecos (idenderecotipo, desendereco, desnumero, desbairro, descidade, desestado, despais, descep, descomplemento, inprincipal)
        VALUES(pidenderecotipo, pdesendereco, pdesnumero, pdesbairro, pdescidade, pdesestado, pdespais, pdescep, pdescomplemento, pinprincipal);
        
        SET pidendereco = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_enderecos

        SET 
            idenderecotipo = pidenderecotipo,
            desendereco = pdesendereco,
            desnumero = pdesnumero,
            desbairro = pdesbairro,
            descidade = pdescidade,
            desestado = pdesestado,
            despais = pdespais,
            descep = pdescep,
            descomplemento = pdescomplemento,
            inprincipal = pinprincipal
        WHERE idendereco = pidendereco;

    END IF;

    CALL sp_enderecos_get(pidendereco);

END