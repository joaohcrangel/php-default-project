CREATE PROCEDURE sp_projectsformats_get(
pidformat INT
)
BEGIN

    SELECT *    
    FROM tb_projectsformats    
    WHERE idformat = pidformat;

END;