CREATE PROCEDURE sp_configuracoestipos_save(
pidconfiguracaotipo INT,
pdesconfiguracaotipo VARCHAR(32)
)
BEGIN

    IF pidconfiguracaotipo = 0 THEN
    
        INSERT INTO tb_configuracoestipos (desconfiguracaotipo)
        VALUES(pdesconfiguracaotipo);
        
        SET pidconfiguracaotipo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_configuracoestipos     
        SET 
            desconfiguracaotipo = pdesconfiguracaotipo        
        WHERE idconfiguracaotipo = pidconfiguracaotipo;

    END IF;

    CALL sp_configuracoestipos_get(pidconfiguracaotipo);

END