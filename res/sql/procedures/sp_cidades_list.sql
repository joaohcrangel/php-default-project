CREATE PROCEDURE sp_cidades_list()
BEGIN

    SELECT *
    FROM tb_cidades a
    INNER JOIN tb_estados b USING(idestado) 
    INNER JOIN tb_paises c USING(idpais);

END