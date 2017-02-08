CREATE PROCEDURE sp_produtosdados_save(
pidproduto INT
)
BEGIN

    CALL sp_produtosdados_remove(pidproduto);
    
    INSERT INTO tb_produtosdados (
        idproduto, idprodutotipo,
        desproduto, vlpreco, desprodutotipo,
        dtinicio, dttermino,
        inremovido
    )
    SELECT 
    a.idproduto, a.idprodutotipo,
    a.desproduto, c.vlpreco, b.desprodutotipo,
    c.dtinicio, c.dttermino,
    a.inremovido
    FROM tb_produtos a
    INNER JOIN tb_produtostipos b ON a.idprodutotipo = b.idprodutotipo
    LEFT JOIN tb_produtosprecos c ON a.idproduto = c.idproduto
    WHERE 
        a.idproduto = pidproduto
        AND
        (
            NOW() BETWEEN c.dtinicio AND c.dttermino
            OR
            (
                dtinicio <= NOW()
                AND
                dttermino IS NULL
            )
        )    
    LIMIT 1;

END