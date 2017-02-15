CREATE PROCEDURE sp_configuracoes_remove(
pidconfiguracao INT
)
BEGIN

    DELETE FROM tb_configuracoes 
    WHERE idconfiguracao = pidconfiguracao;

END