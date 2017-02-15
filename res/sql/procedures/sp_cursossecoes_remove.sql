CREATE PROCEDURE sp_cursossecoes_remove(
pidsecao INT
)
BEGIN

    DELETE FROM tb_cursossecoes 
    WHERE idsecao = pidsecao;

END