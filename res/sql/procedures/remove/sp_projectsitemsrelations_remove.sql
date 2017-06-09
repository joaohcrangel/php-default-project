CREATE PROCEDURE sp_projectsitemsrelations_remove(
pidproject INT
)
BEGIN

    DELETE FROM tb_projectsitemsrelations 
    WHERE idproject = pidproject;

END;