CREATE PROCEDURE sp_projectsformats_remove(
pidformat INT
)
BEGIN

    DELETE FROM tb_projectsformats 
    WHERE idformat = pidformat;

END;