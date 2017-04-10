CREATE PROCEDURE sp_cursossecoes_get(
pidsecao INT
)
BEGIN

    SELECT *    
    FROM tb_cursossecoes    
    WHERE idsecao = pidsecao;

END