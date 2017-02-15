CREATE PROCEDURE sp_configuracoestipos_get(
pidconfiguracaotipo INT
)
BEGIN

    SELECT *    
    FROM tb_configuracoestipos    
    WHERE idconfiguracaotipo = pidconfiguracaotipo;

END