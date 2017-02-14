CREATE PROCEDURE sp_configuracoestipos_remove(
pidconfiguracaotipo INT
)
BEGIN

    DELETE FROM tb_configuracoestipos 
    WHERE idconfiguracaotipo = pidconfiguracaotipo;

END