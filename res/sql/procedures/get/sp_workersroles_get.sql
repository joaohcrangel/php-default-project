CREATE PROCEDURE sp_workersroles_get(
pidrole INT
)
BEGIN

    SELECT *    
    FROM tb_workersroles    
    WHERE idrole = pidrole;

END;