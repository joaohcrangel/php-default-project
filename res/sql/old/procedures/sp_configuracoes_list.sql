CREATE PROCEDURE sp_configuracoes_list()
BEGIN

    SELECT *    
    FROM tb_configuracoes a
    INNER JOIN tb_configuracoestipos b ON a.idconfiguracaotipo = b.idconfiguracaotipo;

END