CREATE PROCEDURE sp_pedidosnegociacoestipos_remove(
pidnegociacao INT
)
BEGIN

    DELETE FROM tb_pedidosnegociacoestipos 
    WHERE idnegociacao = pidnegociacao;

END