CREATE PROCEDURE sp_estados_list()
BEGIN

    SELECT *
    FROM tb_estados a
    INNER JOIN tb_paises b USING(idpais);

END