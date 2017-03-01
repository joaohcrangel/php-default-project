CREATE PROCEDURE sp_pedidosnegociacoestipos_save(
pidnegociacao INT,
pdesnegociacao VARCHAR(64)
)
BEGIN

    IF pidnegociacao = 0 THEN
    
        INSERT INTO tb_pedidosnegociacoestipos (desnegociacao)
        VALUES(pdesnegociacao);
        
        SET pidnegociacao = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pedidosnegociacoestipos        
        SET 
            desnegociacao = pdesnegociacao        
        WHERE idnegociacao = pidnegociacao;

    END IF;

    CALL sp_pedidosnegociacoestipos_get(pidnegociacao);

END