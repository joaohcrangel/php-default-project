CREATE PROCEDURE sp_projects_remove(
pidproject INT
)
BEGIN

    DELETE FROM tb_projects 
    WHERE idproject = pidproject;

END;