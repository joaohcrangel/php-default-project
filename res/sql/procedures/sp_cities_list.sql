CREATE PROCEDURE sp_cities_list()
BEGIN

    SELECT *
    FROM tb_cities a
    INNER JOIN tb_states b USING(idstate) 
    INNER JOIN tb_countries c USING(idcountry);

END