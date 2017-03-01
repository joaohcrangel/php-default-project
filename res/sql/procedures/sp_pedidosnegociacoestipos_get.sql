CREATE PROCEDURE sp_pedidosnegociacoestipos_get(
pidnegociacao INT
)
BEGIN

    SELECT *    
    FROM tb_pedidosnegociacoestipos    
    WHERE idnegociacao = pidnegociacao;

END