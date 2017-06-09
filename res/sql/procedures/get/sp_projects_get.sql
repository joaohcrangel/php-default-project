CREATE PROCEDURE sp_projects_get(
pidproject INT
)
BEGIN

    SELECT *    
    FROM tb_projects    
    WHERE idproject = pidproject;

END;