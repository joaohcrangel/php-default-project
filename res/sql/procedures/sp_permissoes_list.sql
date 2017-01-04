CREATE PROCEDURE sp_permissoes_list()
BEGIN

    SELECT *
    FROM tb_permissoes
    ORDER BY despermissao;

END