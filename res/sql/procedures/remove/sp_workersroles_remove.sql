CREATE PROCEDURE sp_workersroles_remove(
pidrole INT
)
BEGIN

    DELETE FROM tb_workersroles 
    WHERE idrole = pidrole;

END;