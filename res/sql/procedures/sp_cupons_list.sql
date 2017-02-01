CREATE PROCEDURE sp_cupons_list()
BEGIN

    SELECT *
    FROM tb_cupons
    INNER JOIN tb_cuponstipos USING(idcupomtipo);

END