CREATE PROCEDURE sp_projectsitemsrelations_get(
pidproject INT
)
BEGIN

    SELECT *    
    FROM tb_projectsitemsrelations    
    WHERE idproject = pidproject;

END;