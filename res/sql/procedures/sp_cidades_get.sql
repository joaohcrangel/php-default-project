CREATE PROCEDURE sp_cidades_get(
pidcidade INT
)
BEGIN

    SELECT *    
    FROM tb_cidades a
    INNER JOIN tb_estados b USING(idestado) 
    INNER JOIN tb_paises c USING(idpais) 
    WHERE a.idcidade = pidcidade;

END