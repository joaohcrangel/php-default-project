CREATE PROCEDURE sp_configuracoes_get(
pidconfiguracao INT
)
BEGIN

    SELECT *    
    FROM tb_configuracoes    
    WHERE idconfiguracao = pidconfiguracao;

END