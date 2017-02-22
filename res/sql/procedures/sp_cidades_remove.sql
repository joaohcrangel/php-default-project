CREATE PROCEDURE sp_cidades_remove(
pidcidade INT
)
BEGIN

    DELETE FROM tb_cidades 
    WHERE idcidade = pidcidade;

END