CREATE PROCEDURE sp_states_get(
pidstate INT
)
BEGIN

    SELECT *    
    FROM tb_states a
    INNER JOIN tb_countries b USING(idcountry) 
    WHERE a.idstate = pidstate;

END