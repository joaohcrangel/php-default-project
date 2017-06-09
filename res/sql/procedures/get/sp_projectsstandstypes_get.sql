CREATE PROCEDURE sp_projectsstandstypes_get(
pidstandtype INT
)
BEGIN

    SELECT *    
    FROM tb_projectsstandstypes    
    WHERE idstandtype = pidstandtype;

END;