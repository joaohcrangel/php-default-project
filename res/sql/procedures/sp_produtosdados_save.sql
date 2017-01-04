CREATE PROCEDURE sp_produtosdados_save(
pidproduto INT
)
BEGIN

    CALL sp_produtosdados_remove(pidproduto);
    
    INSERT INTO tb_produtosdados (
        idproduto, idprodutotipo,
        desproduto, vlpreco, desprodutotipo,
        dtinicio, dttermino
    )
    SELECT 
    a.idproduto, a.idprodutotipo,
    a.desproduto, a.vlpreco, b.desprodutotipo,
    a.dtinicio, a.dttermino
    FROM tb_produtos a
    INNER JOIN tb_produtostipos b ON a.idprodutotipo = b.idprodutotipo
    WHERE a.idproduto = pidproduto
    LIMIT 1;

END