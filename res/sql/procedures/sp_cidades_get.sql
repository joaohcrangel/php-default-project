CREATE PROCEDURE sp_cidades_get(
pidcidade INT
)
BEGIN

    SELECT *    
    FROM tb_cidades    
    WHERE idcidade = pidcidade;

END